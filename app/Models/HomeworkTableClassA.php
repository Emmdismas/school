<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkTableClassA extends Model
{
    use HasFactory;

    protected $table = 'homework_table_class_a'; // Jina la meza
    protected $fillable = [
        'assignment_name',
        'subject_matter',
        'deadline',
        'assignment_file',
        'file_content',
    ];
}
