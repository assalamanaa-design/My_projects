<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'patient_id',
        'premium_id',
        'admin_id',
        'email',
        'name',
        'message',
        'status',
        'date_sent',
        'created_at',
    ];

    public $timestamps = true; // Car tu utilises `date_sent` au lieu de `created_at`

    // Relations
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function premium()
    {
        return $this->belongsTo(PremiumPatient::class, 'premium_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}


}

