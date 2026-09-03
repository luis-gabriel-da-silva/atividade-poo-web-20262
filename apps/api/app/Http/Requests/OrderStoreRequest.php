<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'costumer_id' => 'required|exists:costumers,id',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pago,cancelado,aberto',
            'paid_at' => 'nullable|date',
        ];
    }
}
