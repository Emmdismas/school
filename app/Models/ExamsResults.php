<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamsResults extends Model
{
    use HasFactory;

    protected $table; // Dynamic table name

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

    // Set table dynamically
    public function setTableName($class, $examType)
    {
        $this->table = strtolower("{$class}_{$examType}_results");
    }
}
