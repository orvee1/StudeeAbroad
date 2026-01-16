<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CityUpdateRequest extends FormRequest
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
        $city   = $this->route('city');
        $cityId = $city?->id;

        $stateId = $this->input('state_id');

        return [
            'state_id'    => ['required', 'integer', 'exists:states,id'],

            'name'        => [
                'required', 'string', 'max:255',
                Rule::unique('cities', 'name')->ignore($cityId)->where(fn($q) => $q->where('state_id', $stateId)),
            ],
            'slug'        => [
                'required', 'string', 'max:255',
                Rule::unique('cities', 'slug')->ignore($cityId)->where(fn($q) => $q->where('state_id', $stateId)),
            ],

            'latitude'    => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'   => ['nullable', 'numeric', 'between:-180,180'],

            'description' => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }
}
