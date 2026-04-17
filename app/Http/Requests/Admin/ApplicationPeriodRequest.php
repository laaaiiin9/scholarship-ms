<?php

namespace App\Http\Requests\Admin;

use App\Models\ApplicationPeriod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationPeriodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'scholarship_id' => 'required|exists:scholarships,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => ['required', Rule::in([
                ApplicationPeriod::STATUS_DRAFT,
                ApplicationPeriod::STATUS_OPEN,
                ApplicationPeriod::STATUS_CLOSED
            ])]
        ];
    }
}
