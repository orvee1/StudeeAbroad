<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UniversityUpdateRequest extends FormRequest
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
        $university = $this->route('university');
        $id         = $university?->id;

        return [
            'country_id'            => ['required', 'integer', 'exists:countries,id'],
            'state_id'              => ['required', 'integer', 'exists:states,id'],
            'city_id'               => ['required', 'integer', 'exists:cities,id'],

            'name'                  => [
                'required', 'string', 'max:255',
                Rule::unique('universities', 'name')
                    ->ignore($id)
                    ->where(fn($q) => $q->where('city_id', $this->input('city_id'))),
            ],
            'slug'                  => ['required', 'string', 'max:255', Rule::unique('universities', 'slug')->ignore($id)],

            'type'                  => ['nullable', 'string', 'max:255'],
            'established_year'      => ['nullable', 'integer', 'min:1000', 'max:2100'],

            'logo'                  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cover'                 => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'address'               => ['nullable', 'string', 'max:255'],
            'website_url'           => ['nullable', 'string', 'max:255'],
            'email'                 => ['nullable', 'email', 'max:255'],
            'phone'                 => ['nullable', 'string', 'max:50'],

            'short_description'     => ['nullable', 'string'],
            'description'           => ['nullable', 'string'],

            'world_ranking'         => ['nullable', 'integer', 'min:1'],
            'acceptance_rate'       => ['nullable', 'numeric', 'between:0,100'],

            'tuition_min'           => ['nullable', 'integer', 'min:0'],
            'tuition_max'           => ['nullable', 'integer', 'min:0'],
            'living_cost_min'       => ['nullable', 'integer', 'min:0'],
            'living_cost_max'       => ['nullable', 'integer', 'min:0'],

            'application_fee'       => ['nullable', 'integer', 'min:0'],
            'scholarship_available' => ['nullable', 'boolean'],

            'is_featured'           => ['nullable', 'boolean'],
            'is_active'             => ['nullable', 'boolean'],
            'sort_order'            => ['nullable', 'integer', 'min:0'],

            'meta_title'            => ['nullable', 'string', 'max:255'],
            'meta_description'      => ['nullable', 'string', 'max:500'],
        ];
    }
}
