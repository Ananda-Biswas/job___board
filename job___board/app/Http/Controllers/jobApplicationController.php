<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\job;
class jobApplicationController extends Controller
{
    public function create(job $job)
    {
        $this-> authorize('apply', $job);
        return view('job_application.create',['job'=> $job]);
    }

    public function store(Job $job, Request $request)
    {
        $this-> authorize('apply', $job);

        $validatedData = $request-> validate([
                'expected_salary' => 'required|min:1|max:10000000',
                'cv' => 'required|file|mimes:pdf|max:2048'
        ]);

        $file = $request-> file('cv');
        $path = $file-> store('cvs', 'private');

        $job-> jobApplication()-> create([
            'user_id'=> $request->user()->id,
            'expected_salary' => $validatedData['expected_salary'],
            'cv_path' => $path
            
            
        ]);

        return redirect()-> route('jobs.show', $job)
        -> with('success', 'Job application submitted');
    }

    public function destroy(string $id)
    {
        //
    }
}
