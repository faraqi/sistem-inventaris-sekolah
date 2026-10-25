<?php

namespace App\Http\Requests;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'item_id' => ['required', 'exists:items,id'],
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $item = Item::find($this->item_id);
                    if ($item && $value > $item->stock) {
                        $fail("Jumlah peminjaman ({$value}) melebihi stok barang yang tersedia ({$item->stock}).");
                    }
                },
            ],
            'loan_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:loan_date'],
        ];

        if ($this->user()?->isAdmin()) {
            $rules['user_id'] = ['required', 'exists:users,id'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'item_id.required' => 'Barang wajib dipilih.',
            'item_id.exists' => 'Barang yang dipilih tidak valid.',
            'user_id.required' => 'Pengguna/Peminjam wajib dipilih.',
            'user_id.exists' => 'Pengguna yang dipilih tidak valid.',
            'quantity.required' => 'Jumlah barang wajib diisi.',
            'quantity.min' => 'Jumlah barang minimal 1.',
            'loan_date.required' => 'Tanggal peminjaman wajib diisi.',
            'due_date.required' => 'Batas waktu pengembalian wajib diisi.',
            'due_date.after_or_equal' => 'Batas pengembalian harus tanggal yang sama atau setelah tanggal peminjaman.',
        ];
    }
}
