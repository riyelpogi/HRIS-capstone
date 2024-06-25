<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'admin_employee_id',
        'job_title',
        'job_description',
        'job_responsibilities',
        'job_qualifications',
        'job_department',
        'job_skills_required',
        'hiring_limit',
        'hiring_date',
        'hiring_closing_date',
        'status'
    ];


    public function shortlisteds()
    {
        return $this->hasMany(Interviewee::class, 'job_id', 'job_id')
                                        ->where('interview_type', 'final')
                                        ->where('status', 'passed');
    }

    public function applicants()
    {
        return $this->hasMany(jobApplicants::class, 'job_id', 'job_id')->orderBy('created_at', 'desc');
    }
}
