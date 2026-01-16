<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StateStoreRequest extends FormRequest
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
        $countryId = $this->input('country_id');

        return [
            'country_id'  => ['required', 'integer', 'exists:countries,id'],

            'name'        => [
                'required', 'string', 'max:255',
                Rule::unique('states', 'name')->where(fn($q) => $q->where('country_id', $countryId)),
            ],
            'slug'        => [
                'required', 'string', 'max:255',
                Rule::unique('states', 'slug')->where(fn($q) => $q->where('country_id', $countryId)),
            ],

            'code'        => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],

            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }
}
