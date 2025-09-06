<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ToolRequest extends FormRequest
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
        $tool = $this->route('tool');

        return [
            'title'       => ['required', 'string', 'max:255'],
            'link'        => ['required', 'url:http,https', 'max:2048', Rule::unique('tools')->ignore($tool)],
            'description' => ['nullable', 'string'],
            'tags'        => ['nullable', 'array'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string'   => 'The title must be a valid string.',
            'title.max'      => 'The title may not be greater than 255 characters.',

            'link.required' => 'The link field is required.',
            'link.url'      => 'The link must be a valid URL starting with http or https.',
            'link.unique'   => 'This link has already been taken.',
            'link.max'      => 'The link may not be greater than 2048 characters.',

            'description.string' => 'The description must be a valid string.',

            'tags.array' => 'The tags must be an array of values.',
        ];
    }
}
