<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Lead;
use App\Models\University;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    private const GENDERS = ['Male', 'Female', 'Other', 'Prefer not to say'];

    private const EDUCATION_QUALIFICATIONS = [
        'Below SSC',
        'SSC / O Level',
        'HSC / A Level',
        'Diploma',
        'Bachelor\'s degree',
        'Master\'s degree',
        'PhD',
        'Other',
    ];

    private const ENGLISH_PROFICIENCIES = ['IELTS', 'Duolingo', 'PTE', 'TOEFL', 'None'];

    private const BANGLADESH_DISTRICTS = [
        'Bagerhat', 'Bandarban', 'Barguna', 'Barishal', 'Bhola', 'Bogura',
        'Brahmanbaria', 'Chandpur', 'Chapainawabganj', 'Chattogram', 'Chuadanga',
        "Cox's Bazar", 'Cumilla', 'Dhaka', 'Dinajpur', 'Faridpur', 'Feni',
        'Gaibandha', 'Gazipur', 'Gopalganj', 'Habiganj', 'Jamalpur', 'Jashore',
        'Jhalokathi', 'Jhenaidah', 'Joypurhat', 'Khagrachhari', 'Khulna',
        'Kishoreganj', 'Kurigram', 'Kushtia', 'Lakshmipur', 'Lalmonirhat',
        'Madaripur', 'Magura', 'Manikganj', 'Meherpur', 'Moulvibazar',
        'Munshiganj', 'Mymensingh', 'Naogaon', 'Narail', 'Narayanganj',
        'Narsingdi', 'Natore', 'Netrokona', 'Nilphamari', 'Noakhali', 'Pabna',
        'Panchagarh', 'Patuakhali', 'Pirojpur', 'Rajbari', 'Rajshahi', 'Rangamati',
        'Rangpur', 'Satkhira', 'Shariatpur', 'Sherpur', 'Sirajganj', 'Sunamganj',
        'Sylhet', 'Tangail', 'Thakurgaon',
    ];

    public function start(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'desired_country_id' => ['nullable', 'integer', Rule::exists('countries', 'id')->where('is_active', true)],
            'desired_university_id' => ['nullable', 'integer', Rule::exists('universities', 'id')->where('is_active', true)],
            'desired_level' => ['nullable', 'string', 'max:40'],
            'preferred_intake' => ['nullable', 'string', 'max:20'],
            'source' => ['required', Rule::in(['landing'])],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        if (! $this->universityMatchesCountry($data)) {
            return back()->withErrors(['desired_university_id' => 'Choose a university in the selected country.'])->withInput();
        }

        $data['message'] = $this->cleanMessage($data['message'] ?? null);
        $token = (string) Str::uuid();
        $drafts = $request->session()->get('enquiry_drafts', []);
        $drafts[$token] = $data;
        $request->session()->put('enquiry_drafts', $drafts);

        return redirect()->route('enquiries.details', $token);
    }

    public function details(string $draft): RedirectResponse|\Illuminate\View\View
    {
        $draftData = session('enquiry_drafts', [])[$draft] ?? null;
        if (! $draftData) {
            return redirect()->route('home')->withFragment('enquiry')->with('error', 'Your guidance request expired. Please start again.');
        }

        return view('client.enquiries.complete', [
            'draft' => $draft,
            'draftData' => $draftData,
            'desiredCountryName' => ! empty($draftData['desired_country_id'])
                ? Country::query()->whereKey($draftData['desired_country_id'])->value('name')
                : null,
            'desiredUniversityName' => ! empty($draftData['desired_university_id'])
                ? University::query()->whereKey($draftData['desired_university_id'])->value('name')
                : null,
            'genders' => self::GENDERS,
            'districts' => self::BANGLADESH_DISTRICTS,
            'qualifications' => self::EDUCATION_QUALIFICATIONS,
            'proficiencies' => self::ENGLISH_PROFICIENCIES,
        ]);
    }

    public function complete(Request $request): RedirectResponse
    {
        $token = $request->validate(['draft_token' => ['required', 'uuid']])['draft_token'];
        $drafts = $request->session()->get('enquiry_drafts', []);
        $draftData = $drafts[$token] ?? null;

        if (! $draftData) {
            return redirect()->route('home')->withFragment('enquiry')->with('error', 'Your guidance request expired. Please start again.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', Rule::in(self::GENDERS)],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
            'district' => ['nullable', Rule::in(self::BANGLADESH_DISTRICTS)],
            'highest_education' => ['nullable', Rule::in(self::EDUCATION_QUALIFICATIONS)],
            'highest_education_passing_year' => ['nullable', 'integer', 'between:1950,' . now()->year],
            'english_proficiency' => ['required', Rule::in(self::ENGLISH_PROFICIENCIES)],
        ]);

        $data = array_merge($draftData, $data);
        $data['email'] = mb_strtolower($data['email']);
        $data['status'] = 'new';

        Lead::create($data);

        unset($drafts[$token]);
        $request->session()->put('enquiry_drafts', $drafts);

        return redirect()->route('home')->withFragment('enquiry')->with('success', 'Your enquiry has been received. Our team will be in touch soon.');
    }

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
            'source' => ['required', Rule::in(['landing', 'destination', 'university', 'program', 'contact'])],
            'message' => [$request->input('source') === 'contact' ? 'required' : 'nullable', 'string', 'max:2000'],
        ]);

        if (! $this->universityMatchesCountry($data)) {
            return back()->withErrors(['desired_university_id' => 'Choose a university in the selected country.'])->withInput();
        }

        $data['message'] = $this->cleanMessage($data['message'] ?? null);

        $data['email'] = mb_strtolower($data['email']);
        $data['status'] = 'new';

        Lead::create($data);

        return back()->withFragment('enquiry')->with('success', 'Your enquiry has been received. Our team will be in touch soon.');
    }

    private function universityMatchesCountry(array $data): bool
    {
        if (empty($data['desired_university_id']) || empty($data['desired_country_id'])) {
            return true;
        }

        return University::query()
            ->whereKey($data['desired_university_id'])
            ->where('country_id', $data['desired_country_id'])
            ->exists();
    }

    private function cleanMessage(?string $message): ?string
    {
        $message = trim(strip_tags($message ?? ''));

        return $message !== '' ? $message : null;
    }
}
