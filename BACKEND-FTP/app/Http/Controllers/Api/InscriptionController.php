<?php

namespace App\Http\Controllers\API; 

use App\Http\Controllers\Controller; 
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InscriptionController extends Controller
{
    public function store(Request $request)
    {
        
        if (!Auth::check()) {
            return response()->json(['message' => 'Non authentifié'], 401);
        }

        
        try {
            $request->validate([
                'formation_id' => 'required|exists:formations,id',
                'moyen_paiement' => 'required|string',
                'montant_paye' => 'required|numeric',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Données invalides', 'error' => $e->getMessage()], 422);
        }

        
        try {
            $inscription = Inscription::create([
                'user_id'          => Auth::id(),
                'formation_id'     => $request->formation_id,
                'moyen_paiement'   => $request->moyen_paiement,
                'montant_paye'     => $request->montant_paye,
                'statut'           => 'paye'
            ]);

            return response()->json($inscription, 201);

        } catch (\Exception $e) {
            Log::error("Erreur inscription : " . $e->getMessage());
            return response()->json([
                'message' => 'Erreur serveur lors de l\'inscription',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}