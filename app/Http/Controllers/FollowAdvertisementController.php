<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\FollowAdvertisement;
use App\Models\Advertisement;

class FollowAdvertisementController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'lastname' => 'required|string',
                'firstname' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'message' => 'required|string',
                'advertisement_id' => 'required|integer',
            ]);

            $advertisement = Advertisement::find($request->advertisement_id);

            if (!$advertisement) {
                return response()->json(['message' => 'Annonce non trouvée'], 404);
            }

            if ($request->user() && $advertisement->company->user_id === $request->user()->id) {
                return response()->json(['message' => 'Vous ne pouvez pas postuler à votre propre annonce'], 400);
            }

            $emailSent = "Votre candidature pour le poste de " . $advertisement->title . " a bien été envoyée à " . $advertisement->company->name . ". Vous serez contacté si votre candidature est retenue.";

            $data = [
                'email_sent' => $emailSent,
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
                'status' => 'SENT',
                'advertisement_id' => $request->advertisement_id,
            ];
            
            if ($request->user_id) {
                $data['user_id'] = $request->user_id;
            }
            
            $followAdvertisement = FollowAdvertisement::create($data);

            try {
                Mail::send('email.name', ['data1' => $data], function($m) use ($data, $advertisement) {
                    $m->to($data['email'])->subject('Candidature pour le poste de ' . $advertisement->title);
                });
            
                return response()->json(['message' => 'Candidature effectuée avec succès'], 201);
            
            } catch (\Exception $e) {
                return response()->json(['message' => 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
