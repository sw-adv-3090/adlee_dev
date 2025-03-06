<?php

namespace App\Http\Requests;

use App\Enums\TemplateLanguage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TemplateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'preview' => ['required', 'string'],
            'content' => ['required', 'string'],
            'language' => ['required', Rule::enum(TemplateLanguage::class)],
            'publish_at' => ['nullable', 'date'],
            'category_id' => ['nullable', 'string', 'exists:categories,id'],
            'sub_category_id' => ['nullable', 'string', 'exists:sub_categories,id']
        ];
    }
}
