<?php

namespace App\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'conditions' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'product_id' => ['required', 'integer', Rule::exists('products', 'id')],
            'buyer_id' => ['required', 'integer', Rule::exists('users', 'id')],
        ];
    }
}
