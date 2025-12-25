<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\job;
use \App\Http\Requests\JobReuest;

class MyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAnyEmployer', job::class);
        return view('my_job.index',
    [
        'jobs' => auth()-> user()->employer
        ->jobs()
        -> with(['employer', 'jobApplication', 'jobApplication.user'])
        ->withTrashed()
        ->paginate(10)
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', job::class);
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobReuest $request)
    {
        $this->authorize('create', job::class);
        $request-> user()-> employer-> jobs()->create($request->validated());

        return redirect()-> route('my_jobs.index')
        -> with('success', 'Job created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(job $myJob)
    {
        $this->authorize('update', $myJob);
        return view('my_job.edit', ['job'=> $myJob]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobReuest $request, job $myJob)
    {
        $this->authorize('update', $myJob);
        $myJob->update($request->validated());

        return redirect()->route('my_jobs.index')
        ->with('success', 'Job Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(job $myJob)
    {
        $myJob->delete();
         
        return redirect()->route('my_jobs.index')
        ->with('success', 'Job deleted.');
    }
}
