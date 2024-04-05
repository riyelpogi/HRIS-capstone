<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'evaluation_question_id',
        'evaluated',
        'evaluator',
        'qone',
        'qtwo',
        'qthree',
        'qfour',
        'qfive',
        'qsix',
        'qseven',
        'qeight',
        'qnine',
        'qten',
        'total',
        'recommendation',
        'month',
        'year',
        'grade',
        'dep_employee'
    ];

    public function evaluation_question()
    {
        return $this->belongsTo(EvaluationQuestion::class, 'evaluation_question_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'evaluated', 'employee_id');
    }

}
