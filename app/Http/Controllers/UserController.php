<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index ()
    {
        $users = User::all();
        return response()->json($users, 200);
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|email|unique:users',
                'phone' => 'required|string',
                'password' => 'required|string',
            ]);

            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'role' => 'USER',
            ]);

            return response()->json(['message' => 'Utilisateur créé avec succès', 201]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !password_verify($request->password, $user->password)) {
            return response()->json(['message' => 'Email ou mot de passe invalide'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'user' => $user,
            'token' => $token],
            200
        );
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Déconnexion réussie'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        // Trouver l'utilisateur par son ID
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "Utilisateur non trouvé"
            ], 404);
        }

        // Validation des données à mettre à jour
        $validator = Validator::make($request->all(), [
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'email' => 'email|unique:users,email,'.$user->id, // Ignorer l'email actuel
            'phone' => 'string|max:15',
            'address' => 'string|max:255',
            'zip_code' => 'string|max:10',
            'city' => 'string|max:100',
            'password' => 'nullable|string|min:8', // Le mot de passe n'est pas obligatoire
            'role' => 'string',
            'company_id' => 'nullable|integer|exists:companies,id'
        ]);

        // Retourner les erreurs de validation
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 400);
        }

        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'firstname' => $request->firstname ?? $user->firstname,
            'lastname' => $request->lastname ?? $user->lastname,
            'email' => $request->email ?? $user->email,
            'phone' => $request->phone ?? $user->phone,
            'address' => $request->address ?? $user->address,
            'zip_code' => $request->zip_code ?? $user->zip_code,
            'city' => $request->city ?? $user->city,
            'password' => $request->password ? Hash::make($request->password) : $user->password, // Si le mot de passe est envoyé, le hacher
            'role' => $request->role ?? $user->role,
            'company_id' => $request->company_id ?? $user->company_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur mis à jour avec succès',
            'data' => $user
        ], 200);
    }



    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès'], 200);
    }
}
