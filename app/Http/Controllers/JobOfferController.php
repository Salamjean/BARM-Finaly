<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Repositories\JobOfferRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $skills = JobOffer::all();
        $jobs = JobOffer::all();
        return view('dashboard.job.index', ['skills'=>$skills ,'jobs' => (new JobOfferRepository)->index()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = $request->validate([
            'email' => 'required',
            'phone_number' => 'required',
            'description' => 'required',
            'job_type' => 'required',
            'title' => 'required',
            'pay' => 'nullable',
            'number' => 'nullable',
            'skills' => 'nullable',
            'education' => 'nullable|array',
            'language' => 'nullable|array',
            'gender' => 'nullable|array',
            'benefits' => 'nullable',
            'location' => 'required',
            'end_date' => 'required|date',
        ]);

        $message = (new JobOfferRepository())->store($attrs);

        return to_route('job.index')->with('success', $message);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = (new JobOfferRepository())->show($id);
        $skills = json_decode($job->skills, true);
        return view('front.pages.single_offre', ['job' => $job, 'skills' => $skills]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOffer $job)
    {
        return view('dashboard.job.edit', ['data' => $job]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobOffer $job)
    {
        $attrs = $request->validate([
            'email' => 'required',
            'phone_number' => 'required',
            'description' => 'required',
            'job_type' => 'required',
            'title' => 'required',
            'pay' => 'nullable',
            'number' => 'nullable',
            'skills' => 'nullable',
            'education' => 'nullable|array',
            'language' => 'nullable|array',
            'gender' => 'nullable|array',
            'benefits' => 'nullable',
            'location' => 'required',
            'end_date' => 'required|date',
            'status' => 'nullable',
        ]);

        $message = (new JobOfferRepository())->update($attrs, $job -> id);

        return to_route('job.index')->with('success', $message);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOffer $job)
    {
        $job->delete();
        return to_route('job.index')->with('success', MESSAGES['job']['delete']);

    }
}
