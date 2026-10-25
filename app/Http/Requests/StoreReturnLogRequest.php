<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'loan_id' => ['required', 'exists:loans,id', 'unique:return_logs,loan_id'],
            'returned_at' => ['required', 'date'],
            'condition_on_return' => ['required', 'in:baik,rusak ringan,rusak berat'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'loan_id.required' => 'Peminjaman wajib dipilih.',
            'loan_id.unique' => 'Peminjaman ini sudah memiliki catatan pengembalian.',
            'returned_at.required' => 'Tanggal dikembalikan wajib diisi.',
            'condition_on_return.required' => 'Kondisi barang saat pengembalian wajib dipilih.',
        ];
    }
}
