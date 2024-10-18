<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends Controller
{
    // Méthode pour obtenir toutes les annonces d'emploi
    public function index()
    {
        $advertisement = Advertisement::all();
        return $advertisement; // Retourne toutes les annonces
    }

    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'sector' => 'required|string',
            'description' => 'required|string',
            'wage' => 'required|numeric',
            'working_time' => 'required|string',
            'skills' => 'required|string',
            'tags' => 'nullable|string',
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'status' => 'required|boolean',
        ]);

        // Retourner les erreurs de validation
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Créer l'annonce
        $advertisement = Advertisement::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Annonce créée avec succès',
            'data' => $advertisement
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Trouver l'annonce par son ID
        $advertisement = Advertisement::find($id);

        if (!$advertisement) {
            return response()->json([
                'success' => false,
                'message' => "Annonce non trouvée"
            ], 404);
        }

        // Validation des données à mettre à jour
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'type' => 'string',
            'sector' => 'string',
            'description' => 'string',
            'wage' => 'numeric',
            'working_time' => 'string',
            'skills' => 'string',
            'tags' => 'nullable|string',
            'zip_code' => 'string|max:10',
            'city' => 'string|max:100',
            'status' => 'boolean',
        ]);

        // Retourner les erreurs de validation
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Mettre à jour les informations de l'entité
        $advertisement->update([

        'title' => $request->title ?? $advertisement->title,
        'type' => $request->type ?? $advertisement->type,
        'sector' => $request->sector ?? $advertisement->sector,
        'description' => $request->description ?? $advertisement->description,
        'wage' => $request->wage ?? $advertisement->wage,
        'working_time' => $request->working_time ?? $advertisement->working_time,
        'skills' => $request->skills ?? $advertisement->skills,
        'tags' => $request->tags ?? $advertisement->tags,
        'zip_code' => $request->zip_code ?? $advertisement->zip_code,
        'city' => $request->city ?? $advertisement->city,
        'status' => $request->status ?? $advertisement->status,
        'company_id' => $request->company_id ?? $advertisement->company_id
    ]);


        return response()->json([
            'success' => true,
            'message' => 'Annonce mise à jour avec succès',
            'data' => $advertisement
        ], 200);
    }


    public function destroy($id)
    {
        $Advertisement = Advertisement::find($id);

        if (!$Advertisement) {
            return response()->json(['message' => 'Annonce non trouvé'], 404);
        }

        $Advertisement->delete();

        return response()->json(['message' => 'Annonce supprimé avec succès'], 200);
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

