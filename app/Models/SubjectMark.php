<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_result_id',
        'subject_name',
        'mark',
    ];

    public function examResult()
    {
        return $this->belongsTo(ExamResult::class);
    }
}
