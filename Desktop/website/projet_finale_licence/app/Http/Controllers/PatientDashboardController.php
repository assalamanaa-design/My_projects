<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Message;
use App\Models\Patient;
use App\Models\PremiumPatient;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Récupérer l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            return redirect()->route('login'); // Ou une page d'erreur si tu préfères
        }

        $nextAppointment = null;
        $messages = collect();

        if ($user->type == 'patient') {
            // Utiliser la relation pour récupérer le patient en fonction de l'email
            $patient = Patient::whereHas('user', function ($query) use ($user) {
                $query->where('email', $user->email); // Vérifier l'email
            })->first();

            // Vérifier si le patient existe
            if ($patient) {
                // Récupérer le prochain rendez-vous du patient
                $nextAppointment = Appointment::where('email', $user->email)
                    ->where('date', '>=', now()->toDateString())
                    ->orderBy('date', 'asc')
                    ->first();

                // Récupérer les messages du patient
                $messages = Message::where('patient_id', $patient->id)
                    ->whereNotNull('admin_reply')
                    ->orderBy('date_sent', 'desc')
                    ->get();
            }

            // Passer les données à la vue
            return view('patient.dashboardd', [
                'nextAppointment' => $nextAppointment,
                'messages' => $messages,
            ]);

        } elseif ($user->type == 'premium_patient') {
            // Utiliser la relation pour récupérer le premium patient en fonction de l'email
            $premium = PremiumPatient::whereHas('user', function ($query) use ($user) {
                $query->where('email', $user->email); // Vérifier l'email
            })->first();

            // Vérifier si le patient existe
            if ($premium) {
                // Récupérer le prochain rendez-vous du patient
                $nextAppointment = Appointment::where('email', $user->email)
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date', 'asc')
                ->first();

                // Récupérer les messages du premium patient
                $messages = Message::where('premium_id', $premium->id)
                    ->whereNotNull('admin_reply')
                    ->orderBy('date_sent', 'desc')
                    ->get();
            }
            return view('premium.dashboard', [
                'nextAppointment' => $nextAppointment,
                'messages' => $messages,
            ]);

        } else {
            // Si l'utilisateur a un type inconnu, rediriger ou afficher une erreur
            return redirect()->route('home')->withErrors('Utilisateur non autorisé');
        }
    }
}
