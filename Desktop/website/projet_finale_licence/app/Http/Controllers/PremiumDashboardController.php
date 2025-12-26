<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Message;
use App\Models\Patient;
use App\Models\PremiumPatient;

class PremiumDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // utilisateur connecté

        $nextAppointment = null;
        $messages = collect();
        
        if ($user && $user->type == 'premium_patient') {
            // Ici on récupère l'objet premium patient
            $premium = PremiumPatient::whereHas('user', function ($query) use ($user) {
                $query->where('email', $user->email);
            })->first();
        
            if ($premium) {
                $nextAppointment = Appointment::where('email', $user->email)
                    ->where('date', '>=', now()->toDateString())
                    ->orderBy('date', 'asc')
                    ->first();
        
                $messages = Message::where('premium_id', $premium->id)
                    ->whereNotNull('admin_reply')
                    ->orderBy('date_sent', 'desc')
                    ->get();
            }
        
            return view('premium.dashboarddd', [
                'nextAppointment' => $nextAppointment,
                'messages' => $messages,
            ]);
        }
    }        
}
