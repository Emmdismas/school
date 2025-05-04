<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model  

{
    use HasFactory;

    protected $table = 'exam_results';

    protected $fillable = [
        'school_id',
        'class',
        'exam_type',
        'academic_year',
        'month',
        'student_id',
        'student_name',
        'subject_1',
        'subject_2',
        'subject_3',
        'subject_4',
        'subject_5',
        'student_position',
    ];
    // Set table dynamically
    public function setTableName($class, $examType)
    {
        $this->table = strtolower("{$class}_{$examType}_results");
    }
     // Uhusiano na meza ya schools
     public function school()
     {
         return $this->belongsTo(School::class, 'school_id');
     }
}
