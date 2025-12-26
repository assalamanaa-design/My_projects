<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PremiumPatient;
use App\Models\User;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // Affiche la vue avec les rendez-vous
    public function index()
    {
        $today = Carbon::today();

    $appointments = Appointment::with(['patient.user', 'premium.user'])
        ->whereDate('date', '>=', $today)
        ->orderBy('date', 'asc')
        ->get();

    

return view('admin.appointments', compact('appointments'));

        // On prépare les données pour le JS (nom, email, etc.)
        $formattedAppointments = $appointments->map(function ($appointment) {
            $user = $appointment->patient->user ?? $appointment->premium->user;

            return [
                'id' => $appointment->id,
                'name' => $user ? $user->name : 'Unknown',
                'email' => $appointment->email,
                'phone' => $appointment->phone_number,
                'date' => $appointment->date,
                'message' => $appointment->message,
                'status' => $appointment->status
            ];
        });

        return view('admin.appointments', [
            'formattedAppointments' => $formattedAppointments
        ]);
    }
    public function updateStatus($id, $status)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = $status;
        $appointment->save();
    
        return response()->json([
            'message' => "Appointment has been $status successfully!"
        ]);
    }




    // PatientController.php



 public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->date = $request->input('date');
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment updated successfully!');
    }


public function destroy($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->delete();

    return redirect()->back()->with('success', 'Appointment cancelled successfully.');
}

}