<?php

// app/Models/EmergencyLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyLog extends Model
{
    protected $fillable = [
        'student_name', 'narrative', 'timestamp',
    ];
}
