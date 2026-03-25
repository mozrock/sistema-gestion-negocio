<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user && $user->hasAnyRole(['super_admin', 'admin']);
    }

    public function rules(): array
    {
        return [
            'worker_id' => ['required', 'exists:workers,id'],
            'service_id' => ['required', 'exists:services,id'],
            'payment_method_id' => ['nullable', 'exists:payment_methods,id'],
            'service_date' => ['required', 'date'],
            'start_time' => ['nullable'],
            'end_time' => ['nullable'],
            'service_price' => ['required', 'numeric', 'min:0'],
            'room_cost' => ['nullable', 'numeric', 'min:0'],
            'security_cost' => ['nullable', 'numeric', 'min:0'],
            'advance_payment' => ['nullable', 'numeric', 'min:0'],
            'additional_cost' => ['nullable', 'numeric', 'min:0'],
            'night_cost' => ['nullable', 'numeric', 'min:0'],
            'wipes_cost' => ['nullable', 'numeric', 'min:0'],
            'fine_amount' => ['nullable', 'numeric', 'min:0'],
            'fine_description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}