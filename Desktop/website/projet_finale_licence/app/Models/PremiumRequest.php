<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'card_number', 'is_paid', 'is_approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}