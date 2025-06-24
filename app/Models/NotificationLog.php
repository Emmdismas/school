<?php

namespace App\Models;

use App\Models\Students;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'exam_type',
        'month',
        'academic_year',
        'sent',
        'sent_via',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Students::class);
    }
}
