<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $countryId = $this->route('country')?->id;

        return [
            'name'             => ['required', 'string', 'max:255', Rule::unique('countries', 'name')->ignore($countryId)],
            'slug'             => ['required', 'string', 'max:255', Rule::unique('countries', 'slug')->ignore($countryId)],

            'iso2'             => ['nullable', 'string', 'size:2'],
            'iso3'             => ['nullable', 'string', 'size:3'],

            'currency'         => ['nullable', 'string', 'max:10'],
            'phone_code'       => ['nullable', 'string', 'max:10'],

            'flag'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'description'      => ['nullable', 'string'],
            'sort_order'       => ['nullable', 'integer', 'min:0'],
            'is_active'        => ['nullable', 'boolean'],

            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
