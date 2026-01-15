<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    
    public function store(Request $request)
    {
      
        $request->validate([
            'titre'        => 'required|string|max:255',
            'formation_id' => 'required|integer|exists:formations,id',
            'description'  => 'nullable|string',
            'duree'        => 'required|string|max:50', 
        ]);

        try {
            
            $cours = Cours::create([
                'titre'        => $request->titre,
                'formation_id' => $request->formation_id,
                'description'  => $request->description,
                'duree'        => $request->duree,
                
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cours ajouté avec succès',
                'data'    => $cours
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur : ' . $e->getMessage()
            ], 500);
        }
    }

    
    public function update(Request $request, $id)
    {
        $cours = Cours::find($id);
        if (!$cours) return response()->json(['message' => 'Non trouvé'], 404);

        $request->validate([
            'titre'       => 'sometimes|string|max:255',
            'duree'       => 'sometimes|string|max:50',
            'description' => 'nullable|string',
        ]);

        $cours->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mise à jour réussie',
            'data'    => $cours
        ]);
    }
    
    
    public function show($id)
    {
        return response()->json(Cours::with('ressources')->find($id));
    }
}