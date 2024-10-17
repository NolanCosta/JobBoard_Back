<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{

    public function index()
    {
        $companies = Company::all();
        return response()->json($companies, 200);
    }

    public function store(Request $request)
    {
        if ($request->type === 'true') {
            try {
                $request->validate([
                    'name' => 'required|string',
                    'address' => 'required|string',
                    'zip_code' => 'required|string',
                    'city' => 'required|string',
                    'aboutUs' => 'required|string',
                ]);
                $existingCompany = Company::where('name', $request->name)->first();
                
                if ($existingCompany) {
                    return response()->json(['message' => 'Une entreprise avec ce nom existe déjà.'], 400);
                }

                // dd($request->all());
                $company = Company::create([
                    'name' => $request->name,
                    'address' => $request->address,
                    'zip_code' => $request->zip_code,
                    'city' => $request->city,
                    'aboutUs' => $request->aboutUs,
                    'user_id' => $request->user()->id,
                ]);

                $request->user()->update([
                    'company_id' => $company->id,
                    'role' => 'PRO'
                ]);

                return response()->json(['message' => 'Companie créée avec succès'], 201);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        } else {
            try {
                $request->validate([
                    'company_id' => 'required|string',
                ]);

                $request->user()->update([
                    'company_id' => $request->company_id,
                    'role' => 'PRO'
                ]);

                $company = Company::where('id', $request->company_id)->first();

                if (!$company) {
                    return response()->json(['message' => 'Companie non trouvée'], 404);
                }

                $collaborators = json_decode($company->collaborators, true) ?? [];
                
                if (!in_array($request->user()->id, $collaborators)) {
                    $collaborators[] = $request->user()->id;
                
                    $company->update([
                        'collaborators' => $collaborators
                    ]);
                } else {
                    return response()->json(['message' => 'Vous avez déjà rejoint cette entreprise'], 400);
                }

                return response()->json(['message' => 'Vous avez rejoins ' . $company->name, 'company_id' => $company->id], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
    }

    public function show($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Companie non trouvée'], 404);
        }

        return response()->json($company, 200);
    }


    public function update(Request $request, $id)
    {
        // Trouver l'entité par son ID
        $company = Company::find($id);


        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => "Entreprise non trouvée"
            ], 404);
        }

        // Validation des données à mettre à jour
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'zip_code' => 'required|string',
            'city' => 'required|string',
            'aboutUs' => 'required|string',
        ]);

        // Retourner les erreurs de validation
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 400);
        }

        // // Traitement du logo s'il est présent
        // if ($request->hasFile('logo')) {
        //     // Supprimer l'ancien logo si nécessaire
        //     if ($company->logo) {
        //         Storage::delete($company->logo); // Supposant que le logo est stocké dans un storage
        //     }

        //     // Enregistrer le nouveau logo
        //     $logoPath = $request->file('logo')->store('logos'); // Stocker le fichier logo
        //     $company->logo = $logoPath;
        // }

        // Mettre à jour les informations de l'entreprise
        $company->update([
            'name' => $request->name ?? $company->name,
            'address' => $request->address ?? $company->address,
            'zip_code' => $request->zip_code ?? $company->zip_code,
            'city' => $request->city ?? $company->city,
            'aboutUs' => $request->aboutUs ?? $company->aboutUs,
            'collaborators' => $request->collaborators ?? $company->collaborators,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Entreprise mise à jour avec succès',
            'data' => $company
        ], 200);
    
    }

    public function destroy($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Companie non trouvée'], 404);
        }

        $company->delete();

        return response()->json(['message' => 'Companie supprimée avec succès'], 200);
    }

}
