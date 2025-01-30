<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentListClassB extends Model
{
    use HasFactory;

    protected $table = 'student_list_class_B';
    protected $fillable = [
        'student_number',
        'student_name',
    ];
}
