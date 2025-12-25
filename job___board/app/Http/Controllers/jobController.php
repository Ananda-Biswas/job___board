<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\job;
class jobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {
        $this->authorize('viewAny', job ::class);
        $filters=request()-> only(
        'search',
        'min_salary',
        'max_salary',
        'experience',
        'category');
        return view(
            'job.index', 
            ['jobs' => job::with('employer')->latest()
            ->filter($filters)->paginate(10)]);
    }


    public function show(job $job)
    {
        $this->authorize('view', $job);
        return view('job.show', 
        ['job'=> $job -> load('employer.jobs')]);
    }

}
