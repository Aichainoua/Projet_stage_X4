<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Apprenant;
use App\Models\Formateur;
use App\Models\FormateurDomaine;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Afficher toutes les données enregistrées dans la base de données
     */
    public function getAllData()
    {
        try {
            $users = User::with(['apprenant', 'formateur.domaines'])->get();
            
            $data = [
                'users' => $users->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'nom' => $user->nom,
                        'email' => $user->email,
                        'role' => $user->role,
                        'status' => $user->status,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'apprenant' => $user->apprenant,
                        'formateur' => $user->formateur ? [
                            'id' => $user->formateur->id,
                            'nom_complet' => $user->formateur->nom_complet,
                            'telephone' => $user->formateur->telephone,
                            'code_pays' => $user->formateur->code_pays,
                            'pays' => $user->formateur->pays,
                            'biographie' => $user->formateur->biographie,
                            'competences' => $user->formateur->competences,
                            'experience' => $user->formateur->experience,
                            'niveau_formation' => $user->formateur->niveau_formation,
                            'description_formations' => $user->formateur->description_formations,
                            'cv_url' => $user->formateur->cv_url,
                            'domaines' => $user->formateur->domaines->pluck('domaine')->toArray(),
                            'created_at' => $user->formateur->created_at,
                        ] : null,
                    ];
                }),
                'statistics' => [
                    'total_users' => $users->count(),
                    'total_apprenants' => Apprenant::count(),
                    'total_formateurs' => Formateur::count(),
                    'users_by_role' => [
                        'apprenant' => $users->where('role', 'apprenant')->count(),
                        'formateur' => $users->where('role', 'formateur')->count(),
                    ],
                    'users_by_status' => [
                        'active' => $users->where('status', 'active')->count(),
                        'pending' => $users->where('status', 'pending')->count(),
                        'rejected' => $users->where('status', 'rejected')->count(),
                        'suspended' => $users->where('status', 'suspended')->count(),
                    ],
                ]
            ];
            
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des données',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

