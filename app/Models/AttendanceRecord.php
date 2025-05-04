<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    //
    use HasFactory;
    protected $table = 'attendance_records';
    protected $fillable = [
        'school_id',
        'student_id',
        'student_name', // Hakikisha imeongzwa hapa
        'class',
        'attendance_date',
        'status',
        'total_classes_attended',
        'total_classes',
        'total_percentage',
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
