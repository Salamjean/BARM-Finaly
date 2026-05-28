<?php

namespace App\Repositories;

use App\Models\JobOffer;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class JobOfferRepository.
 */
class JobOfferRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return JobOffer::class;
    }

    public function index()
    {
        return $this->model()::whereUserId(auth()->id())->orderByDESC('created_at')->get();
    }

    public function show($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store(array $data) : string
    {

        $description = $data['description'] == "<p><br></p>" ? null : $data['description'];
        $languages = isset($data['language']) ? json_encode($data['language']) : null;
        $educations = isset($data['education']) ? json_encode($data['education']) : null;
        $genders = isset($data['gender']) ? json_encode($data['gender']) : null;

        $job = new $this->model();
        $job -> reference = 'JOB' . generateRandomString();
        $job -> user_id = auth()->id();
        $job -> title = $data['title'];
        $job -> description = $description;
        $job -> job_type = $data['job_type'];
        $job -> email = $data['email'];
        $job -> phone_number = $data['phone_number'];
        $job -> location = $data['location'] ;
        $job -> number = $data['number'] ?? null;
        $job -> pay = $data['pay'] ?? null;
        $job -> skills = $data['skills'] ?? null;
        $job -> benefits = $data['benefits'] ?? null;
        $job -> languages = $languages;
        $job -> educations = $educations;
        $job -> genders = $genders;
        $job -> end_date = $data['end_date'];
        $job -> save();

        return MESSAGES['job']['store'];
    }

    public function update(array $data, string $id): string
    {
        $description = $data['description'] == "<p><br></p>" ? null : $data['description'];
        $languages = isset($data['language']) ? json_encode($data['language']) : null;
        $educations = isset($data['education']) ? json_encode($data['education']) : null;
        $genders = isset($data['gender']) ? json_encode($data['gender']) : null;
        $status = isset($data['status']) ? 'enable' : 'disable';

        $job = $this->show($id);
        $job->title = $data['title'];
        $job->description = $description;
        $job->job_type = $data['job_type'];
        $job->email = $data['email'];
        $job->phone_number = $data['phone_number'];
        $job->location = $data['location'];
        $job->number = $data['number'] ?? null;
        $job->pay = $data['pay'] ?? null;
        $job->skills = $data['skills'] ?? null;
        $job->benefits = $data['benefits'] ?? null;
        $job->languages = $languages;
        $job->educations = $educations;
        $job->genders = $genders;
        $job->status = $status;
        $job->end_date = $data['end_date'];
        $job->save();

        return MESSAGES['job']['update'];
    }


}
