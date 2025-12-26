<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalScan extends Model
{
    protected $fillable = [
        'patient_id',
        'scan_type',
        'scan_date',
        'image_path',
        'result'
    ];
}

