<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Item;
use App\Models\Loan;
use App\Models\ReturnLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (1 Admin & 2 Users minimum)
        $admin = User::create([
            'name' => 'Muhammad Faqih (Admin)',
            'email' => 'admin@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $user1 = User::create([
            'name' => 'Budi Santoso (Siswa)',
            'email' => 'siswa@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name' => 'Siti Nurhaliza, S.Pd (Guru)',
            'email' => 'guru@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // 2. Seed Categories (4 categories)
        $catLab = Category::create(['name' => 'Alat Laboratorium']);
        $catOlahraga = Category::create(['name' => 'Alat Olahraga']);
        $catElektronik = Category::create(['name' => 'Elektronik & Multimedia']);
        $catKebersihan = Category::create(['name' => 'Alat Kebersihan']);

        // 3. Seed Items (10 items minimum)
        $item1 = Item::create([
            'category_id' => $catElektronik->id,
            'name' => 'Proyektor Epson EB-X400',
            'code' => 'ELK-PRO-001',
            'stock' => 5,
            'condition' => 'baik',
        ]);

        $item2 = Item::create([
            'category_id' => $catElektronik->id,
            'name' => 'Laptop Acer Aspire 5',
            'code' => 'ELK-LAP-002',
            'stock' => 10,
            'condition' => 'baik',
        ]);

        $item3 = Item::create([
            'category_id' => $catOlahraga->id,
            'name' => 'Bola Basket Molten Size 7',
            'code' => 'OLG-BASKET-001',
            'stock' => 12,
            'condition' => 'baik',
        ]);

        $item4 = Item::create([
            'category_id' => $catOlahraga->id,
            'name' => 'Raket Badminton Yonex',
            'code' => 'OLG-RAKET-002',
            'stock' => 8,
            'condition' => 'rusak ringan',
        ]);

        $item5 = Item::create([
            'category_id' => $catLab->id,
            'name' => 'Mikroskop Binokuler Olympus',
            'code' => 'LAB-MIK-001',
            'stock' => 15,
            'condition' => 'baik',
        ]);

        $item6 = Item::create([
            'category_id' => $catLab->id,
            'name' => 'Tabung Reaksi Pyrex (Set)',
            'code' => 'LAB-TAB-002',
            'stock' => 25,
            'condition' => 'baik',
        ]);

        $item7 = Item::create([
            'category_id' => $catKebersihan->id,
            'name' => 'Vakum Cleaner Krisbow 15L',
            'code' => 'KBS-VAC-001',
            'stock' => 3,
            'condition' => 'baik',
        ]);

        $item8 = Item::create([
            'category_id' => $catElektronik->id,
            'name' => 'Speaker Portable Advance 12 Inch',
            'code' => 'ELK-SPK-003',
            'stock' => 4,
            'condition' => 'baik',
        ]);

        $item9 = Item::create([
            'category_id' => $catOlahraga->id,
            'name' => 'Matras Senam Lantai 5cm',
            'code' => 'OLG-MAT-003',
            'stock' => 6,
            'condition' => 'rusak ringan',
        ]);

        $item10 = Item::create([
            'category_id' => $catLab->id,
            'name' => 'Timbangan Digital Presisi',
            'code' => 'LAB-TIM-003',
            'stock' => 7,
            'condition' => 'baik',
        ]);

        // 4. Seed Loans (5 loans minimum)
        $loan1 = Loan::create([
            'user_id' => $user1->id,
            'item_id' => $item3->id,
            'quantity' => 2,
            'loan_date' => Carbon::now()->subDays(10),
            'due_date' => Carbon::now()->subDays(7),
            'status' => 'dikembalikan',
        ]);

        $loan2 = Loan::create([
            'user_id' => $user2->id,
            'item_id' => $item1->id,
            'quantity' => 1,
            'loan_date' => Carbon::now()->subDays(8),
            'due_date' => Carbon::now()->subDays(5),
            'status' => 'dikembalikan',
        ]);

        $loan3 = Loan::create([
            'user_id' => $user1->id,
            'item_id' => $item5->id,
            'quantity' => 2,
            'loan_date' => Carbon::now()->subDays(6),
            'due_date' => Carbon::now()->subDays(3),
            'status' => 'dikembalikan',
        ]);

        $loan4 = Loan::create([
            'user_id' => $user2->id,
            'item_id' => $item2->id,
            'quantity' => 1,
            'loan_date' => Carbon::now()->subDays(2),
            'due_date' => Carbon::now()->addDays(3),
            'status' => 'dipinjam',
        ]);

        $loan5 = Loan::create([
            'user_id' => $user1->id,
            'item_id' => $item4->id,
            'quantity' => 2,
            'loan_date' => Carbon::now()->subDays(12),
            'due_date' => Carbon::now()->subDays(2),
            'status' => 'terlambat',
        ]);

        // 5. Seed Return Logs (3 return logs)
        ReturnLog::create([
            'loan_id' => $loan1->id,
            'returned_at' => Carbon::now()->subDays(7),
            'condition_on_return' => 'baik',
            'notes' => 'Dikembalikan tepat waktu dalam kondisi bersih.',
        ]);

        ReturnLog::create([
            'loan_id' => $loan2->id,
            'returned_at' => Carbon::now()->subDays(5),
            'condition_on_return' => 'baik',
            'notes' => 'Kabel HDMI dan remote lengkap.',
        ]);

        ReturnLog::create([
            'loan_id' => $loan3->id,
            'returned_at' => Carbon::now()->subDays(3),
            'condition_on_return' => 'baik',
            'notes' => 'Lensa mikroskop dalam kondisi prima.',
        ]);

        // 6. Seed Activity Logs
        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'create_category',
            'description' => 'Admin menambahkan kategori "Alat Laboratorium" dan "Alat Olahraga".',
        ]);

        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'create_item',
            'description' => 'Admin menambahkan barang "Proyektor Epson EB-X400" (ELK-PRO-001) stok 5.',
        ]);

        ActivityLog::create([
            'user_id' => $user1->id,
            'action' => 'create_loan',
            'description' => 'Budi Santoso (Siswa) mengajukan peminjaman 2 Bola Basket Molten Size 7.',
        ]);

        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'verify_return',
            'description' => 'Admin memverifikasi pengembalian 2 Bola Basket Molten Size 7 dari Budi Santoso.',
        ]);

        ActivityLog::create([
            'user_id' => $user2->id,
            'action' => 'create_loan',
            'description' => 'Siti Nurhaliza (Guru) mengajukan peminjaman 1 Laptop Acer Aspire 5.',
        ]);
    }
}
