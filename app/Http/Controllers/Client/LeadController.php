<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'desired_country_id' => ['nullable', 'integer', Rule::exists('countries', 'id')->where('is_active', true)],
            'desired_university_id' => ['nullable', 'integer', Rule::exists('universities', 'id')->where('is_active', true)],
            'desired_level' => ['nullable', 'string', 'max:40'],
            'preferred_intake' => ['nullable', 'string', 'max:20'],
            'source' => ['required', Rule::in(['landing', 'destination', 'university', 'program'])],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        if (! empty($data['desired_university_id']) && ! empty($data['desired_country_id'])) {
            $matchesCountry = \App\Models\University::query()
                ->whereKey($data['desired_university_id'])
                ->where('country_id', $data['desired_country_id'])
                ->exists();

            if (! $matchesCountry) {
                return back()->withErrors(['desired_university_id' => 'Choose a university in the selected country.'])->withInput();
            }
        }

        $data['email'] = mb_strtolower($data['email']);
        $data['status'] = 'new';

        Lead::create($data);

        return back()->withFragment('enquiry')->with('success', 'Your enquiry has been received. Our team will be in touch soon.');
    }
}
