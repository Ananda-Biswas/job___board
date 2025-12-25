<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;


class MyJobApplicationController extends Controller
{
    public function index()
    {
        return view('my_job_application.index',
    [
        
            'applications' => auth()-> user()
            ->jobApplication()
            -> with(['job' =>
            fn($query) => $query-> withCount('jobApplication')
            -> withAvg('jobApplication', 'expected_salary')
            ->withTrashed(), 
            'job.employer'])
            -> latest()-> get()
            ]
        );
    }
    public function destroy(JobApplication $myJobApplication)
    {
        $myJobApplication-> delete();
        return redirect()-> back()->with(
            'success',
            'Job Application removed.'
        );
    }
}
