<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'class',
        'exam_type',
        'academic_year',
        'month',
        'student_id',
        'student_name',
        'total_marks',
        'average_marks',
        'student_position',
    ];

    public function subjectMarks()
    {
        return $this->hasMany(SubjectMark::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }
}
