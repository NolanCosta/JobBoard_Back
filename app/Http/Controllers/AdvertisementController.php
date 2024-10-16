<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;

use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    // Méthode pour obtenir toutes les annonces d'emploi
    public function index()
    {
        $advertisement = Advertisement::all();
        return $advertisement; // Retourne toutes les annonces
    }

    // Méthode pour ajouter une nouvelle annonce (si nécessaire)
    public function store(Request $request)
    {
        $Advertisement = Advertisement::create($request->all());
        return response()->json($Advertisement, 201);
    }

    public function show($id)
    {
        $advertisement = Advertisement::with('company')->find($id);

        if (!$advertisement) {
            return response()->json(['message' => 'Annonce non trouvée'], 404);
        }

        return response()->json($advertisement, 200);
    }
}

