<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'birthday',
        'age',
        'department',
        'position',
        'address',
        'city',
        'province',
        'postal_code',
        'country',
        'mobile_number',
        'resume',
        'date_hired',
        'date_regular',
        'barangay',
        'region',
        'deployment_date'
    ];
}
