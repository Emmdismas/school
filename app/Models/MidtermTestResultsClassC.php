<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MidtermTestResultsClassC extends Model
{
    use HasFactory;

    protected $table = 'midterm_test_results_class_c';
    protected $fillable = [
        'student_number',
        'student_name',
        'subject1',
        'subject2',
        'subject3',
        'subject4',
        'subject5',
        'total_marks',
        'average',
        'position',
    ];
}
