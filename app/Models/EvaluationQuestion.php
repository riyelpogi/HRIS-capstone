<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'month',
        'year',
        'status'
    ];

    public function evaluated()
    {
        return $this->hasMany(Evaluation::class, 'evaluation_question_id');
    }


}
