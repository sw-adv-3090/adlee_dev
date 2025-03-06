<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'account_holder_name' => ['required', 'string'],
            'routing_number' => ['required', 'string'],
            'account_number' => ['required', 'string'],
            'account_type' => ['required', 'in:checking,savings'],
            'account_holder_type' => ['required', 'in:individual,company'],
        ];
    }
}
