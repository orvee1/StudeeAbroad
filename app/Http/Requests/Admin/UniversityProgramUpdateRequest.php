<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UniversityProgramUpdateRequest extends FormRequest
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
        $university   = $this->route('university');
        $universityId = $university?->id;

        $program   = $this->route('program');
        $programId = $program?->id;

        return [
            'title'                => ['required', 'string', 'max:255'],
            'slug'                 => [
                'required', 'string', 'max:255',
                Rule::unique('university_programs', 'slug')
                    ->ignore($programId)
                    ->where(fn($q) => $q->where('university_id', $universityId)),
            ],
            'level'                => ['required', 'string', 'max:100'],
            'field'                => ['nullable', 'string', 'max:255'],
            'duration_months'      => ['nullable', 'integer', 'min:1', 'max:600'],
            'language'             => ['nullable', 'string', 'max:100'],
            'tuition_per_year_min' => ['nullable', 'integer', 'min:0'],
            'tuition_per_year_max' => ['nullable', 'integer', 'min:0'],
            'intake_months'        => ['nullable', 'array'],
            'intake_months.*'      => ['string', 'max:20'],
            'entry_requirements'   => ['nullable', 'string'],
            'notes'                => ['nullable', 'string'],
            'is_active'            => ['nullable', 'boolean'],
            'sort_order'           => ['nullable', 'integer', 'min:0'],
        ];
    }
}
