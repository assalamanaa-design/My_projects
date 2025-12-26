<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    // Spécifie que les timestamps doivent être gérés automatiquement
    public $timestamps = false; // Assure que 'created_at' et 'updated_at' seront gérés

    
    protected $fillable = [
        'date', 'phone_number', 'email', 'message', 'patient_id', 'premium_id', 'status','name'
    ];



    public function patient() {
        return $this->belongsTo(Patient::class);
    }
    
    public function premium() {
        return $this->belongsTo(PremiumPatient::class);
    }

}