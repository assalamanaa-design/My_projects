<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; // Assurez-vous d'inclure le modèle Appointment

class BookingController extends Controller
{
    
    public function create()
{
    $user = auth()->user(); // جلب المستخدم المتصل

    // إذا كان patient عادي
    if ($user && $user->type === 'patient') {
        return view('patient.booking');
    }

    // إذا كان premium_patient
    elseif ($user && $user->type === 'premium_patient') {
        return view('premium.booking');
    }

    // إذا ماكانش متعرف عليه
    abort(403, 'Unauthorized');
}

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'phone' => 'required|string',
            'email' => 'required|email',
            'message' => 'nullable|string',
        ]);

        // Créer un nouvel enregistrement dans la table appointments
        $appointment = new Appointment();
        $appointment->name = $request->input('name');
        $appointment->date = $request->input('date');
        $appointment->phone_number = $request->input('phone');
        $appointment->email = $request->input('email');
        $appointment->message = $request->input('message');
        

        // Sauvegarder l'appointment dans la base de données
        $appointment->save();

        // Rediriger ou afficher un message de confirmation
        return redirect()->route('patient.booking')->with('success', 'Appointment booked successfully!');
    }

      
    }
    


