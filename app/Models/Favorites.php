<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'learning_id',
        'type',
        'name',
        'file_name',
        'description',
        
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }

}
