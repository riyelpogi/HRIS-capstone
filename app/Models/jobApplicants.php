<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobApplicants extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'scheduled',
        'application_status'
    ];

    public function job()
    {
        return $this->belongsTo(Jobs::class, 'job_id', 'job_id');
    }

    public function interviews()
    {
        return $this->hasMany(Interviewee::class, 'application_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
