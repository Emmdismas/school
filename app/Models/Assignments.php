<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    //
    use HasFactory;
    protected $table = 'assignments';

    protected $fillable = [
        'school_id',
        'class',
        'assignment_name',
        'assignment_type',
        'subject_master',
        'deadline',
        'assignment_file',
        'file_content'
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id', 'student_id');
    }
     // Uhusiano na meza ya schools
     public function school()
     {
         return $this->belongsTo(School::class, 'school_id');
     }
}
