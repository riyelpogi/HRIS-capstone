<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefits extends Model
{
    use HasFactory;

    protected $fillable = [
        'benefit_name',
        'benefit_description',
        'benefit_requirements',
        'status'
    ];


    public function approvedApplicants()
    {
        return $this->hasMany(BenefitsApplicant::class, 'benefit_id', 'id')->where('status', 'approved');
    }



    public function applicants()
    {
        return $this->hasMany(BenefitsApplicant::class, 'benefit_id', 'id')->where('status', '!=', 'declined');

    }

    public function benefits_applicants()
    {
        return $this->hasMany(BenefitsApplicant::class, 'benefit_id', 'id')->where('status', '!=', 'approved');

    }

    public function beneficiaries()
    {
        return $this->hasMany(BenefitsApplicant::class, 'benefit_id', 'id')->where('status', 'approved')->where('date_approved', '!=', null);
    }

}
