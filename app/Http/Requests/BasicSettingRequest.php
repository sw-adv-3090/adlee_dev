<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BasicSettingRequest extends FormRequest
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
            'company_logo' => ['required_if:old_company_logo,null', 'max:255'],
            'ein_number' => ['required', 'string', 'max:255'],
            'consent_ein_number' => ['required', 'in:on',],
            'default_coupon_payout' => ['required', 'numeric'],
            'paying_commission' => ['required', Rule::enum(UserType::class)],
            'is_commemoration' => ['nullable']
        ];
    }
}
