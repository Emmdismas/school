<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePackageTableClassA extends Model
{
    use HasFactory;

    protected $table = 'homepackage_table_class_a';
    protected $fillable = [
        'assignment_name',
        'subject_matter',
        'uploaded_at',
        'deadline',
        'assignment_file',
    ];
}
