<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkTableClassB extends Model
{
    use HasFactory;

    protected $table = 'homework_table_class_b';
    protected $fillable = [
        'assignment_name',
        'subject_matter',
        'uploaded_at',
        'deadline',
        'assignment_file',
    ];
}
