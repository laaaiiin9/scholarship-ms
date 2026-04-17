<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'scholarship_id' => 'required|exists:scholarships,id',
            'requirements' => 'nullable|array',
            'requirements.*' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240', // 10MB limit per file
        ];
    }
    
    /**
     * Friendly validation messages
     */
    public function messages(): array
    {
        return [
            'requirements.*.file' => 'The uploaded requirement must be a valid file.',
            'requirements.*.mimes' => 'The file must be a type of: pdf, jpg, jpeg, png, doc, docx.',
            'requirements.*.max' => 'The uploaded file must not be greater than 10MB.',
        ];
    }
}
