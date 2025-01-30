<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceTableClassC extends Model
{
    use HasFactory;
    protected $table = 'attendance_table_class_c';

    protected $fillable = [
        'student_number',
        'student_name', // Hakikisha imeongezwa hapa
        'attendance_date',
        'status',
        'total_classes_attended',
        'total_percentage',
    ];
}
