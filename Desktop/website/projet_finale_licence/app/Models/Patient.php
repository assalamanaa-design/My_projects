<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients'; // Nom de la table

    protected $primaryKey = 'id'; // La clé primaire est 'id'

    public $timestamps = false; // Désactiver les timestamps car il n’y a pas de `created_at` et `updated_at`

    protected $fillable = [
        'id',
        'birth_date',
        'phone_number',
        'gender',
        'blood_type',
        'allergies',
    ];


    // Dans le modèle Patient.php


public function user()
{
    return $this->belongsTo(User::class, 'id', 'id');
}
    
}



