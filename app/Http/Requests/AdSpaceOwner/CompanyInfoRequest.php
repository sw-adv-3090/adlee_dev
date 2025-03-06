<?php

namespace App\Http\Requests\AdSpaceOwner;

use Illuminate\Foundation\Http\FormRequest;

class CompanyInfoRequest extends FormRequest
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
            'company_name' => ['required', 'string', 'max:255'],
            'company_phone' => ['required', 'string', 'max:255'],
            'old_company_logo' => ['nullable', 'string', 'max:255'],
            'company_logo' => ['required_if:old_company_logo,null', 'string', 'max:255'],
        ];
    }
}
