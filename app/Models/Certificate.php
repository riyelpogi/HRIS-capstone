<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'certificate_name',
        'certificate_info',
        'certificate_file_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }

}
