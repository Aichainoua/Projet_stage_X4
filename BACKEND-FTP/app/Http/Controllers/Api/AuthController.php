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
use Illuminate\Support\Facades\Auth; // Indispensable pour le login

class AuthController extends Controller
{
    /**
     * Inscription d'un Apprenant (Simple)
     */
    public function registerApprenant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $user = DB::transaction(function () use ($request) {
                // 1. Créer le User
                $user = User::create([
                    'name' => $request->prenom . ' ' . $request->nom,
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'apprenant',
                    'status' => 'active',
                ]);

                // 2. Créer le profil Apprenant
                Apprenant::create(['user_id' => $user->id]);

                return $user;
            });

            // 3. Générer le token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Inscription réussie',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur serveur: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Inscription d'un Formateur (Complexe avec CV)
     */
    public function registerFormateur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // User infos
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            
            // Formateur infos
            'pays_id' => 'required|exists:pays,id',
            'date_naissance' => 'required|date',
            'telephone' => 'required|string',
            'biographie' => 'required|string',
            'specialite' => 'required|string',
            'competences' => 'required|string',
            'annees_experience' => 'required|integer',
            'niveau_etude' => 'required|string',
            'description_experience' => 'required|string',
            
            // Fichier CV (PDF max 2Mo)
            'cv' => 'required|file|mimes:pdf|max:2048', 
            'lien_linkedin' => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $result = DB::transaction(function () use ($request) {
                
                // 1. Upload du CV
                $cvPath = null;
                if ($request->hasFile('cv')) {
                    $cvPath = $request->file('cv')->store('cvs', 'public');
                }

                // 2. Créer User (Status pending)
                $user = User::create([
                    'name' => $request->prenom . ' ' . $request->nom,
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'formateur',
                    'status' => 'pending', // En attente de validation
                ]);

                // 3. Créer Profil Formateur
                Formateur::create([
                    'user_id' => $user->id,
                    'pays_id' => $request->pays_id,
                    'telephone' => $request->telephone,
                    'date_naissance' => $request->date_naissance,
                    'biographie' => $request->biographie,
                    'specialite' => $request->specialite,
                    'competences' => $request->competences,
                    'annees_experience' => $request->annees_experience,
                    'niveau_etude' => $request->niveau_etude,
                    'description_experience' => $request->description_experience,
                    'cv_url' => $cvPath,
                    'lien_linkedin' => $request->lien_linkedin,
                ]);

                return $user;
            });

            return response()->json([
                'message' => 'Demande enregistrée. Votre compte est en attente de validation par un administrateur.',
                'user' => $result
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => "Erreur lors de l'enregistrement: " . $e->getMessage()], 500);
        }
    }

    /**
     * Connexion (Login)
     */
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // Vérification du statut
        if ($user->status !== 'active') {
            return response()->json(['message' => 'Votre compte est suspendu ou en attente de validation.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $user->role,
            'user' => $user
        ]);
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}