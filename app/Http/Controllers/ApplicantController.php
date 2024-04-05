<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicantController extends Controller
{

    public function ApplicationHistory()
    {
        return view('users.applicant.application-history');
    }

    public function ApplicantProfile()
    {
        return view('users.applicant.profile');
    }

    public function ApplicantDashboard()
    {
        return view('users.applicant.dashboard');
    }
}
