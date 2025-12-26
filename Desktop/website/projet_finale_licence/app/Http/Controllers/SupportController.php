<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;

class SupportController extends Controller
{
   
    public function help()
{
    $user = Auth::user();

    // Récupérer tous les messages (si besoin للعرض في admin مثلاً)
    $messages = Message::with('user')->orderByDesc('date_sent')->get();

    if ($user->type === 'patient') {
        return view('patient.help', compact('messages'));
    } elseif ($user->type === 'premium_patient') {
        return view('premium.help', compact('messages'));
    } else {
        abort(403, 'Unauthorized');
    }
}

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
    
        $user = Auth::user();
        // Crée un nouveau message
        $message = new Message();
        $message->name = $user->name; 
        $message->email = $request->email;
        $message->message = $request->message;
        $message->created_at = now(); // Ajoute cette ligne si tu veux gérer la date manuellement
        $message->save();

        // Détection du type de patient et assignation de l'ID
        if (Auth::check()) {
            $user = Auth::user();
    
            

            if ($user->type === 'patient') {
                $patient = \App\Models\Patient::where('user_id', $user->id)->first();
                if ($patient) {
                    $message->patient_id = $patient->id;
                }
            } elseif ($user->type === 'premium_patient') {
                $premium = \App\Models\PremiumPatient::where('user_id', $user->id)->first();
                if ($premium) {
                    $message->premium_id = $premium->id;
                }
            }
        }
       
        // Sauvegarde du message dans la base de données
        $message->save();
    
        return redirect()->back()->with('success', 'Your message has been sent successfully.');
    }
    public function resolveMessage($id)
{
    $message = Message::findOrFail($id);

    // Mettre à jour le statut à 'Resolved'
    $message->status = 'Resolved';
    $message->save();

    return back()->with('success', 'Message marked as resolved.');
}

public function replyToMessage(Request $request, $id)
{
    $request->validate([
        'reply' => 'required|string',
    ]);

    $message = Message::findOrFail($id);
    $message->admin_reply = $request->reply;
    $message->status = 'Resolved';
    $message->save();

    Notification::create([
        'user_id' => $message->patient_id ?? $message->premium_id,
        'title' => 'Réponse de l\'administrateur',
        'content' => 'Vous avez reçu une réponse à votre message.',
    ]);
    

    return redirect()->back()->with('success', 'Reply saved successfully.');
}


    

}
