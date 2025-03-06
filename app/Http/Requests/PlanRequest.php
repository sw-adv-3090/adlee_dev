<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
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
        $sponsor = UserType::SPONSOR->value;
        return [
            'type' => ['required', 'string', Rule::enum(UserType::class)],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'ach_transaction_fee' => [
                "required_if:type,$sponsor",
                Rule::when(
                    $this->input('type') === $sponsor,
                    'numeric',
                    'nullable'
                ),
            ],
            'credit_card_transaction_fee' => [
                "required_if:type,$sponsor",
                Rule::when(
                    $this->input('type') === $sponsor,
                    'numeric',
                    'nullable'
                ),
            ],
            'transaction_service_fee' => [
                "required_if:type,$sponsor",
                Rule::when(
                    $this->input('type') === $sponsor,
                    'numeric',
                    'nullable'
                ),
            ],
            'template_limit' => [
                "required_if:type,$sponsor",
                Rule::when(
                    $this->input('type') === $sponsor,
                    'numeric',
                    'nullable'
                ),
            ],
            'booklet_fee' => [
                "required_if:type,$sponsor",
                Rule::when(
                    $this->input('type') === $sponsor,
                    'numeric',
                    'nullable'
                ),
            ],
            'free_booklets' => [
                "required_if:type,$sponsor",
                Rule::when(
                    $this->input('type') === $sponsor,
                    'numeric',
                    'nullable'
                ),
            ],
            'booklet_pages' => [
                "required_if:type,$sponsor",
                Rule::when(
                    $this->input('type') === $sponsor,
                    'numeric',
                    'nullable'
                ),
            ],
        ];
    }
}
