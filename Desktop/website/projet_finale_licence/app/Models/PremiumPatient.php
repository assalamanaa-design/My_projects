<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\PremiumPatientController;

class PremiumPatient extends Model
{
   
    use HasFactory;
    

    
    protected $table = 'premium_patients'; // Nom de la table
    

    protected $primaryKey = 'id'; // La clé primaire est 'id'

    public $timestamps = false; // Désactiver les timestamps car il n’y a pas de `created_at` et `updated_at`


    

    protected $fillable = ['user_id'];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
