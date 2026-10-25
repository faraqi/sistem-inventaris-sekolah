<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Item;
use App\Models\Loan;
use App\Models\ReturnLog;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Pengujian menyeluruh Sistem Inventaris Sekolah untuk role Admin dan User,
 * mengikuti checklist Pre-Production, Production Stage 1 dan Production Stage 2.
 *
 * Jalankan: php artisan test
 */
class InventarisTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $siswa;
    private User $guru;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed();
        $this->admin = User::where('email', 'admin@sekolah.sch.id')->firstOrFail();
        $this->siswa = User::where('email', 'siswa@sekolah.sch.id')->firstOrFail();
        $this->guru = User::where('email', 'guru@sekolah.sch.id')->firstOrFail();
    }

    // ---------- Data & seeder ----------
    public function test_seeder_fills_all_six_tables(): void
    {
        $this->assertGreaterThanOrEqual(3, User::count());
        $this->assertGreaterThanOrEqual(4, Category::count());
        $this->assertGreaterThanOrEqual(10, Item::count());
        $this->assertGreaterThanOrEqual(5, Loan::count());
        $this->assertGreaterThanOrEqual(3, ReturnLog::count());
        $this->assertGreaterThanOrEqual(5, ActivityLog::count());
    }

    // ---------- Halaman terbuka tanpa error ----------
    public function test_every_admin_page_returns_200(): void
    {
        $item = Item::first();
        $loan = Loan::first();
        $cat = Category::first();
        $ret = ReturnLog::first();
        $urls = [
            '/dashboard', '/items', "/items/{$item->id}", '/items/create', "/items/{$item->id}/edit",
            '/loans', '/loans/create', "/loans/{$loan->id}", '/loans/report',
            '/categories', '/categories/create', "/categories/{$cat->id}/edit",
            '/returns', '/returns/create', "/returns/{$ret->id}",
            '/activity-logs', '/users', '/users/create', "/users/{$this->siswa->id}/edit", '/profile',
        ];
        $bad = [];
        foreach ($urls as $u) {
            $s = $this->actingAs($this->admin)->get($u)->getStatusCode();
            if ($s !== 200) {
                $bad[] = "$u => $s";
            }
        }
        $this->assertSame([], $bad, 'Halaman Admin tidak 200: ' . implode(', ', $bad));
    }

    public function test_every_user_page_returns_200(): void
    {
        $item = Item::first();
        $loan = Loan::where('user_id', $this->siswa->id)->first();
        $bad = [];
        foreach (['/dashboard', '/items', "/items/{$item->id}", '/loans', '/loans/create', "/loans/{$loan->id}", '/profile'] as $u) {
            $s = $this->actingAs($this->siswa)->get($u)->getStatusCode();
            if ($s !== 200) {
                $bad[] = "$u => $s";
            }
        }
        $this->assertSame([], $bad, 'Halaman User tidak 200: ' . implode(', ', $bad));
    }

    public function test_auth_pages_open_for_guest(): void
    {
        foreach (['/login', '/register', '/forgot-password'] as $u) {
            $this->get($u)->assertOk();
        }
    }

    // ---------- Role / middleware ----------
    public function test_user_is_blocked_from_admin_routes(): void
    {
        $item = Item::first();
        $bad = [];
        foreach (['/categories', '/returns', '/returns/create', '/activity-logs', '/users', '/users/create',
                  '/items/create', "/items/{$item->id}/edit", '/loans/report'] as $u) {
            $s = $this->actingAs($this->siswa)->get($u)->getStatusCode();
            if ($s !== 403) {
                $bad[] = "$u => $s";
            }
        }
        $this->assertSame([], $bad, 'Seharusnya 403: ' . implode(', ', $bad));
    }

    public function test_guest_is_redirected_to_login(): void
    {
        foreach (['/dashboard', '/items', '/loans', '/users', '/returns'] as $u) {
            $this->get($u)->assertRedirect('/login');
        }
    }

    public function test_user_cannot_see_other_users_loans(): void
    {
        $this->actingAs($this->siswa)->get('/loans')->assertDontSee('Siti Nurhaliza');
        $guruLoan = Loan::where('user_id', $this->guru->id)->first();
        $this->actingAs($this->siswa)->get("/loans/{$guruLoan->id}")->assertForbidden();
    }

    public function test_dashboards_differ_per_role(): void
    {
        $admin = $this->actingAs($this->admin)->get('/dashboard');
        $user = $this->actingAs($this->siswa)->get('/dashboard');
        $admin->assertViewIs('dashboard.admin');
        $user->assertViewIs('dashboard.user');
    }

    // ---------- Peminjaman & pengembalian ----------
    public function test_loan_decrements_stock_and_logs_activity(): void
    {
        $item = Item::where('code', 'LAB-MIK-001')->first();
        $before = $item->stock;
        $this->actingAs($this->siswa)->post('/loans', [
            'item_id' => $item->id, 'quantity' => 3,
            'loan_date' => now()->toDateString(), 'due_date' => now()->addDays(3)->toDateString(),
        ])->assertRedirect('/loans');
        $this->assertSame($before - 3, $item->fresh()->stock);
        $this->assertDatabaseHas('loans', ['user_id' => $this->siswa->id, 'item_id' => $item->id, 'quantity' => 3, 'status' => 'dipinjam']);
        $this->assertDatabaseHas('activity_logs', ['action' => 'create_loan', 'user_id' => $this->siswa->id]);
    }

    public function test_admin_can_create_loan_for_a_user(): void
    {
        $item = Item::where('code', 'ELK-SPK-003')->first();
        $this->actingAs($this->admin)->post('/loans', [
            'user_id' => $this->guru->id, 'item_id' => $item->id, 'quantity' => 1,
            'loan_date' => now()->toDateString(), 'due_date' => now()->addDays(2)->toDateString(),
        ])->assertRedirect('/loans');
        $this->assertDatabaseHas('loans', ['user_id' => $this->guru->id, 'item_id' => $item->id]);
    }

    public function test_loan_over_stock_is_rejected(): void
    {
        $item = Item::where('code', 'KBS-VAC-001')->first();
        $before = $item->stock;
        $this->actingAs($this->siswa)->post('/loans', [
            'item_id' => $item->id, 'quantity' => $before + 5,
            'loan_date' => now()->toDateString(), 'due_date' => now()->addDays(3)->toDateString(),
        ])->assertSessionHasErrors('quantity');
        $this->assertSame($before, $item->fresh()->stock);
    }

    public function test_return_records_condition_notes_and_restores_stock(): void
    {
        $item = Item::where('code', 'ELK-LAP-002')->first();
        $loan = Loan::where('item_id', $item->id)->where('status', 'dipinjam')->first();
        $stockBefore = $item->stock;
        $this->actingAs($this->admin)->post('/returns', [
            'loan_id' => $loan->id, 'returned_at' => now()->toDateString(),
            'condition_on_return' => 'rusak ringan', 'notes' => 'Layar tergores',
        ])->assertRedirect('/returns');
        $this->assertSame('dikembalikan', $loan->fresh()->status);
        $this->assertSame($stockBefore + $loan->quantity, $item->fresh()->stock);
        $this->assertDatabaseHas('return_logs', ['loan_id' => $loan->id, 'condition_on_return' => 'rusak ringan', 'notes' => 'Layar tergores']);
        $this->assertDatabaseHas('activity_logs', ['action' => 'verify_return']);
    }

    public function test_cannot_return_same_loan_twice(): void
    {
        $returned = Loan::where('status', 'dikembalikan')->first();
        $this->actingAs($this->admin)->post('/returns', [
            'loan_id' => $returned->id, 'returned_at' => now()->toDateString(), 'condition_on_return' => 'baik',
        ])->assertSessionHasErrors('loan_id');
    }

    public function test_user_cannot_post_return(): void
    {
        $loan = Loan::where('status', 'dipinjam')->first();
        $this->actingAs($this->siswa)->post('/returns', [
            'loan_id' => $loan->id, 'returned_at' => now()->toDateString(), 'condition_on_return' => 'baik',
        ])->assertForbidden();
    }

    public function test_deleting_active_loan_gives_stock_back(): void
    {
        $item = Item::where('code', 'LAB-TIM-003')->first();
        $before = $item->stock;
        $this->actingAs($this->siswa)->post('/loans', [
            'item_id' => $item->id, 'quantity' => 2,
            'loan_date' => now()->toDateString(), 'due_date' => now()->addDays(3)->toDateString(),
        ]);
        $this->assertSame($before - 2, $item->fresh()->stock);

        $loan = Loan::where('item_id', $item->id)->latest('id')->first();
        $this->actingAs($this->admin)->delete("/loans/{$loan->id}");

        $this->assertSoftDeleted('loans', ['id' => $loan->id]);
        $this->assertSame($before, $item->fresh()->stock, 'Stok harus kembali saat peminjaman aktif dihapus');
    }

    public function test_deleting_returned_loan_does_not_change_stock(): void
    {
        $loan = Loan::where('status', 'dikembalikan')->first();
        $before = $loan->item->stock;
        $this->actingAs($this->admin)->delete("/loans/{$loan->id}");
        $this->assertSoftDeleted('loans', ['id' => $loan->id]);
        $this->assertSame($before, $loan->item->fresh()->stock);
    }

    // ---------- CRUD & soft delete ----------
    public function test_item_crud_soft_delete_and_restore(): void
    {
        $cat = Category::first();
        $this->actingAs($this->admin)->post('/items', [
            'category_id' => $cat->id, 'name' => 'Barang Uji', 'code' => 'UJI-001', 'stock' => 1500, 'condition' => 'baik',
        ])->assertRedirect('/items');
        $item = Item::where('code', 'UJI-001')->firstOrFail();

        $this->actingAs($this->admin)->put("/items/{$item->id}", [
            'category_id' => $cat->id, 'name' => 'Barang Uji Edit', 'code' => 'UJI-001', 'stock' => 20, 'condition' => 'rusak ringan',
        ])->assertRedirect('/items');
        $this->assertDatabaseHas('items', ['id' => $item->id, 'name' => 'Barang Uji Edit', 'stock' => 20]);

        $this->actingAs($this->admin)->delete("/items/{$item->id}");
        $this->assertSoftDeleted('items', ['id' => $item->id]);

        $this->actingAs($this->admin)->post("/items/{$item->id}/restore");
        $this->assertNotSoftDeleted('items', ['id' => $item->id]);
    }

    public function test_item_validation_rules(): void
    {
        $cat = Category::first();
        $this->actingAs($this->admin)->post('/items', [
            'category_id' => $cat->id, 'name' => '', 'code' => 'ELK-PRO-001', 'stock' => -5, 'condition' => 'baik',
        ])->assertSessionHasErrors(['name', 'code', 'stock']);
    }

    public function test_category_crud_and_protection(): void
    {
        $this->actingAs($this->admin)->post('/categories', ['name' => 'Kategori Uji'])->assertRedirect('/categories');
        $cat = Category::where('name', 'Kategori Uji')->firstOrFail();
        $this->actingAs($this->admin)->put("/categories/{$cat->id}", ['name' => 'Kategori Uji 2'])->assertRedirect('/categories');
        $this->actingAs($this->admin)->delete("/categories/{$cat->id}")->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', ['id' => $cat->id]);

        $used = Category::whereHas('items')->first();
        $this->actingAs($this->admin)->delete("/categories/{$used->id}")->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $used->id]);
    }

    public function test_user_management_crud(): void
    {
        $this->actingAs($this->admin)->post('/users', [])->assertSessionHasErrors(['name', 'email', 'password', 'role']);
        $this->actingAs($this->admin)->post('/users', [
            'name' => 'Akun Uji', 'email' => 'uji@sekolah.sch.id', 'password' => 'rahasia123', 'role' => 'user',
        ])->assertRedirect('/users');
        $this->assertDatabaseHas('users', ['email' => 'uji@sekolah.sch.id', 'role' => 'user']);
        $this->assertDatabaseHas('activity_logs', ['action' => 'create_user']);

        $new = User::where('email', 'uji@sekolah.sch.id')->first();
        $this->actingAs($this->admin)->put("/users/{$new->id}", [
            'name' => 'Akun Uji Edit', 'email' => 'uji@sekolah.sch.id', 'role' => 'admin',
        ])->assertRedirect('/users');
        $this->assertDatabaseHas('users', ['id' => $new->id, 'name' => 'Akun Uji Edit', 'role' => 'admin']);

        $this->actingAs($this->admin)->delete("/users/{$new->id}")->assertRedirect('/users');
        $this->assertDatabaseMissing('users', ['id' => $new->id]);
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $this->actingAs($this->admin)->delete("/users/{$this->admin->id}")->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    // ---------- Pagination, search, filter ----------
    public function test_pagination_and_search_work(): void
    {
        $cat = Category::first();
        for ($i = 1; $i <= 25; $i++) {
            Item::create(['category_id' => $cat->id, 'name' => "Massal $i", 'code' => "MSL-$i", 'stock' => 1, 'condition' => 'baik']);
        }
        $r = $this->actingAs($this->admin)->get('/items?search=Massal');
        $r->assertOk();
        $this->assertSame(10, $r->viewData('items')->count());
        $this->assertSame(25, $r->viewData('items')->total());
        $this->actingAs($this->admin)->get('/items?search=Massal&page=3')->assertOk();
    }

    public function test_every_table_has_search_and_filter(): void
    {
        // Barang
        $r = $this->actingAs($this->admin)->get('/items?condition=rusak+ringan');
        $this->assertTrue($r->viewData('items')->every(fn ($i) => $i->condition === 'rusak ringan'));

        // Peminjaman
        $r = $this->actingAs($this->admin)->get('/loans?status=terlambat');
        $this->assertTrue($r->viewData('loans')->every(fn ($l) => $l->status === 'terlambat'));

        // User
        $r = $this->actingAs($this->admin)->get('/users?role=admin');
        $this->assertTrue($r->viewData('users')->every(fn ($u) => $u->role === 'admin'));

        // Pengembalian
        $r = $this->actingAs($this->admin)->get('/returns?condition=baik');
        $this->assertSame(3, $r->viewData('returnLogs')->total());
        $this->actingAs($this->admin)->get('/returns?condition=rusak+berat')->assertViewHas('returnLogs', fn ($p) => $p->total() === 0);

        // Kategori
        $empty = Category::create(['name' => 'Kosong']);
        $r = $this->actingAs($this->admin)->get('/categories?filter=empty');
        $this->assertSame([$empty->id], $r->viewData('categories')->pluck('id')->all());
        $r = $this->actingAs($this->admin)->get('/categories?filter=with_items');
        $this->assertFalse($r->viewData('categories')->contains('id', $empty->id));

        // Activity log
        $r = $this->actingAs($this->admin)->get('/activity-logs?action=create_loan');
        $this->assertTrue($r->viewData('activities')->every(fn ($a) => $a->action === 'create_loan'));
        $this->assertGreaterThan(0, $r->viewData('activities')->count());
    }

    public function test_every_list_page_shows_filter_dropdown(): void
    {
        $missing = [];
        foreach (['/items', '/loans', '/users', '/returns', '/categories', '/activity-logs'] as $u) {
            $c = $this->actingAs($this->admin)->get($u)->getContent();
            if (! str_contains($c, '<select')) {
                $missing[] = $u;
            }
        }
        $this->assertSame([], $missing, 'Halaman tanpa dropdown filter: ' . implode(', ', $missing));
    }

    // ---------- Standar kualitas (Production Stage 2) ----------
    public function test_all_forms_use_form_request_classes(): void
    {
        $targets = [
            [\App\Http\Controllers\ItemController::class, ['store', 'update']],
            [\App\Http\Controllers\CategoryController::class, ['store', 'update']],
            [\App\Http\Controllers\LoanController::class, ['store']],
            [\App\Http\Controllers\ReturnLogController::class, ['store']],
            [\App\Http\Controllers\UserController::class, ['store', 'update']],
        ];
        $missing = [];
        foreach ($targets as [$cls, $methods]) {
            foreach ($methods as $m) {
                $type = (new \ReflectionMethod($cls, $m))->getParameters()[0]->getType()?->getName();
                if (! $type || ! is_subclass_of($type, FormRequest::class)) {
                    $missing[] = class_basename($cls) . "@$m";
                }
            }
        }
        $this->assertSame([], $missing, 'Belum pakai FormRequest: ' . implode('; ', $missing));
    }

    public function test_naming_conventions(): void
    {
        $this->assertSame('users', (new User)->getTable());
        $this->assertSame('categories', (new Category)->getTable());
        $this->assertSame('items', (new Item)->getTable());
        $this->assertSame('loans', (new Loan)->getTable());
        $this->assertSame('return_logs', (new ReturnLog)->getTable());
        $this->assertSame('activity_logs', (new ActivityLog)->getTable());
        foreach (['Item', 'Category', 'Loan', 'ReturnLog', 'User', 'ActivityLog', 'Dashboard', 'Profile'] as $name) {
            $this->assertTrue(class_exists("App\\Http\\Controllers\\{$name}Controller"), "{$name}Controller tidak ada");
        }
    }

    public function test_dates_use_indonesian_locale_and_wib(): void
    {
        $this->assertSame('id', app()->getLocale());
        $this->assertSame('Asia/Jakarta', config('app.timezone'));
        $loan = Loan::where('status', 'dipinjam')->first();
        $expected = $loan->due_date->locale('id')->translatedFormat('d M Y');
        $this->actingAs($this->admin)->get('/loans')->assertSee($expected);
        $this->assertSame('Okt', \Carbon\Carbon::create(2026, 10, 9)->translatedFormat('M'));
    }

    public function test_thousand_separator_is_indonesian(): void
    {
        $cat = Category::first();
        Item::create(['category_id' => $cat->id, 'name' => 'Stok Besar', 'code' => 'BIG-1', 'stock' => 1234567, 'condition' => 'baik']);
        $this->actingAs($this->admin)->get('/items?search=Stok+Besar')->assertSee('1.234.567');
    }

    public function test_required_fields_show_red_asterisk_autofocus_and_placeholder(): void
    {
        $bad = [];
        foreach (['/items/create', '/categories/create', '/users/create', '/loans/create', '/returns/create'] as $u) {
            $c = $this->actingAs($this->admin)->get($u)->getContent();
            if (! str_contains($c, 'autofocus')) {
                $bad[] = "$u tanpa autofocus";
            }
            if (! preg_match('/text-rose-500">\*</', $c)) {
                $bad[] = "$u tanpa bintang merah";
            }
            if (! str_contains($c, 'placeholder=')) {
                $bad[] = "$u tanpa placeholder";
            }
        }
        $this->assertSame([], $bad, implode('; ', $bad));
    }

    public function test_page_headers_and_buttons_are_rendered(): void
    {
        $this->actingAs($this->admin)->get('/returns/create')->assertSee('Verifikasi & Catat Pengembalian Barang', false);
        $this->actingAs($this->admin)->get('/returns')->assertSee('+ Catat Pengembalian Baru', false);
        $this->actingAs($this->admin)->get("/users/{$this->siswa->id}/edit")->assertSee('Edit Akun User', false);
    }

    public function test_breadcrumbs_exist_on_inner_pages(): void
    {
        $item = Item::first();
        $this->actingAs($this->admin)->get('/items')->assertSee('aria-label="Breadcrumb"', false)->assertSee('Katalog Barang');
        $this->actingAs($this->admin)->get("/items/{$item->id}/edit")->assertSee('Edit Barang');
        $this->actingAs($this->admin)->get('/returns/create')->assertSee('Catat Pengembalian');
        $this->actingAs($this->admin)->get('/users')->assertSee('Manajemen User');
    }

    public function test_urls_are_consistent_without_admin_prefix(): void
    {
        $prefixed = collect(Route::getRoutes()->getRoutes())
            ->filter(fn ($r) => str_starts_with($r->uri(), 'admin'))
            ->map(fn ($r) => $r->uri())->all();
        $this->assertSame([], $prefixed, 'Masih ada URL berawalan /admin: ' . implode(', ', $prefixed));
    }

    public function test_tables_scroll_horizontally_on_mobile(): void
    {
        foreach (['/loans', '/items', '/users', '/returns', '/categories', '/activity-logs'] as $u) {
            $c = $this->actingAs($this->admin)->get($u)->getContent();
            $this->assertStringContainsString('overflow-x-auto', $c, "$u tabel tidak punya overflow-x-auto");
        }
    }

    public function test_layout_has_mobile_menu_and_no_dead_links(): void
    {
        $c = $this->actingAs($this->admin)->get('/dashboard')->getContent();
        $this->assertStringContainsString('md:hidden', $c);
        $this->assertStringNotContainsString('href="#"', $c);
    }
}
