<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lead;

class EnquiryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $enquiries = Lead::query()
            ->where('email', $user->email)
            ->with(['desiredCountry:id,name,slug', 'desiredUniversity:id,name,slug'])
            ->latest()
            ->paginate(10);

        return view('student.enquiries.index', compact('enquiries'));
    }
}
