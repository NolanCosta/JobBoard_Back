<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{

    public function index()
    {
        $companies = Company::all();
        return response()->json($companies, 200);
    }

    public function store(Request $request)
    {

        if ($request->type === true) {
            try {
                $request->validate([
                    'name' => 'required|string',
                    'address' => 'required|string',
                    'zipCode' => 'required|integer',
                    'city' => 'required|string',
                    'description' => 'required|string',
                ]);

                $existingCompany = Company::where('name', $request->name)->first();

                if ($existingCompany) {
                    return response()->json(['message' => 'Une entreprise avec ce nom existe déjà.'], 400);
                }

                $company = Company::create([
                    'name' => $request->name,
                    'address' => $request->address,
                    'zip_code' => $request->zipCode,
                    'city' => $request->city,
                    'aboutUs' => $request->description,
                    'user_id' => $request->user()->id,
                ]);

                $request->user()->update([
                    'company_id' => $company->id
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
                    'company_id' => $request->company_id
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
}
