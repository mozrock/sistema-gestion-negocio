<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkerRequest extends FormRequest
{
    public function authorize(): bool
    {
$user = $this->user();

        return $user && $user->hasAnyRole(['super_admin', 'admin']);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'document' => ['required', 'string', 'max:20', 'unique:workers,document'],
            'phone' => ['nullable', 'string', 'max:50'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
{
    return [
        'document.unique' => 'Ya existe una trabajadora con ese documento.',
        'name.required' => 'El nombre es obligatorio.',
        'document.required' => 'El documento es obligatorio.',
        'is_active.required' => 'El estado es obligatorio.',
    ];
}
}
