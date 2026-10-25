<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $itemId = $this->route('item')?->id ?? $this->route('item');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('items', 'code')->ignore($itemId),
            ],
            'stock' => ['required', 'integer', 'min:0'],
            'condition' => ['required', 'in:baik,rusak ringan,rusak berat'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'name.required' => 'Nama barang wajib diisi.',
            'code.required' => 'Kode barang wajib diisi.',
            'code.unique' => 'Kode barang sudah terdaftar.',
            'stock.required' => 'Jumlah stok barang wajib diisi.',
            'condition.required' => 'Kondisi barang wajib dipilih.',
        ];
    }
}
