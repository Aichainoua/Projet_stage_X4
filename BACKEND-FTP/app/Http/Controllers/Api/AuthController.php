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
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function registerApprenant(Request $request)
    {
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
            $user = DB::transaction(function () use ($request) {
                
                
                $user = User::create([
                    'nom' => $request->nom, 
                    'prenom' => $request->prenom,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'apprenant',
                    'status' => 'active', 
                ]);
              
               
                Apprenant::create(['user_id' => $user->id]);

                return $user;
            });

            
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

    public function registerFormateur(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
           
            'pays_id' => 'required|exists:pays,id', 
            'telephone' => 'required|string',
            'biographie' => 'nullable|string',
            'specialite' => 'required|string', 
            'competences' => 'required|string', 
            'annees_experience' => 'required|integer',
            'niveau_etude' => 'required|string',
            'description_experience' => 'required|string',
            
           
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120', 
            
      
            'date_naissance' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction(); 

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
                'telephone' => $request->telephone,
                'date_naissance' => $request->date_naissance ?? null,
                'biographie' => $request->biographie ?? $request->description_experience,
                'specialite' => $request->specialite,
                'competences' => $request->competences,
                'annees_experience' => $request->annees_experience,
                'niveau_etude' => $request->niveau_etude,
                'description_experience' => $request->description_experience,
                'cv' => $cvPath, 
            ]);

            DB::commit(); 
            
            return response()->json([
                'message' => 'Demande enregistrée. Votre compte est en attente de validation par un administrateur.',
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack(); 
            
            
            if (isset($cvPath)) {
                Storage::disk('public')->delete($cvPath);
            }

            return response()->json(['message' => "Erreur lors de l'enregistrement", 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Connexion (Login) avec vérification stricte du statut
     */
    public function login(Request $request)
    {
        // Validation basique
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Données invalides'], 422);
        }

        
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }

       
        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->status === 'pending') {
            
            Auth::logout();
            
            $request->session()->invalidate();
            
            return response()->json([
                'message' => 'Votre compte est en cours de validation par l\'administration.'
            ], 403);
        }

        if ($user->status === 'rejected' || $user->status === 'suspended') {
            Auth::logout();
            $request->session()->invalidate();
            
            return response()->json([
                'message' => 'Votre compte a été suspendu ou refusé. Contactez le support.'
            ], 403);
        }

        // 3. Si tout est bon (Apprenant ou Formateur validé), on génère le token API
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
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
        // Supprime le token actuel
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}