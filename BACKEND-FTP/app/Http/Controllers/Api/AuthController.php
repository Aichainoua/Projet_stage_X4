<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Apprenant;
use App\Models\Formateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Inscription d'un Apprenant (Simple)
     */
    public function registerApprenant(Request $request)
    {
        // 1. Validation
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // 2. Transaction pour garantir que tout est créé ou rien du tout
            $result = DB::transaction(function () use ($request) {
                
                // Création du User
                $user = User::create([
                    'nom' => $request->nom,      // J'ai corrigé ici (tu avais mis nom . ' ' . nom)
                    'prenom' => $request->prenom,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'apprenant',
                    'status' => 'active',
                ]);

                // Création du profil Apprenant
                // ATTENTION : Assure-toi que le modèle Apprenant a 'user_id' dans $fillable
                Apprenant::create(['user_id' => $user->id]);

                // Génération du token
                $token = $user->createToken('auth_token')->plainTextToken;

                return [
                    'user' => $user,
                    'token' => $token
                ];
            });

            // 3. Réponse JSON propre (C'est ça que Nuxt attend !)
            return response()->json([
                'message' => 'Inscription réussie',
                'access_token' => $result['token'],
                'token_type' => 'Bearer',
                'user' => $result['user']
            ], 201);

        } catch (\Exception $e) {
            // En cas d'erreur serveur (ex: base de données plantée)
            return response()->json(['error' => 'Erreur serveur: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Inscription d'un Formateur
     */
    public function registerFormateur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'pays_id' => 'required|exists:pays,id',
            // J'ai allégé la validation pour le test, tu pourras remettre le reste après
            'specialite' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = DB::transaction(function () use ($request) {
                // Upload CV simplifié
                $cvPath = null;
                if ($request->hasFile('cv')) {
                    $cvPath = $request->file('cv')->store('cvs', 'public');
                }

                $user = User::create([
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'formateur',
                    'status' => 'pending',
                ]);

                Formateur::create([
                    'user_id' => $user->id,
                    'pays_id' => $request->pays_id,
                    'specialite' => $request->specialite,
                    'cv_url' => $cvPath,
                    // Ajoute les autres champs ici si nécessaire
                ]);

                return $user;
            });

            return response()->json([
                'message' => 'Demande enregistrée. En attente de validation.',
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => "Erreur: " . $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->status !== 'active') {
            return response()->json(['message' => 'Compte suspendu ou en attente.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $user->role,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}