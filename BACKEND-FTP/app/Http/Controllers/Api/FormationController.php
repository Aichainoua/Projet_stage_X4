<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; 
class FormationController extends Controller
{
    
    public function index()
    {
        $user = auth('sanctum')->user();
        
        $formations = Formation::with(['user', 'cours'])
            ->latest()
            ->get()
            ->map(function ($formation) use ($user) {
               
                if ($user) {
                    $formation->est_paye = $formation->inscriptions()
                                                     ->where('user_id', $user->id)
                                                     ->exists();
                } else {
                    $formation->est_paye = false;
                }
                return $formation;
            });

        return response()->json($formations);
    }

       public function mesFormations()
    {
        $user = Auth::user();
        if (!$user) return response()->json(['message' => 'Non authentifié'], 401);

        $formations = Formation::whereHas('inscriptions', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('user')
        ->withCount('cours')
        ->get();

        $formations->map(function($f) { $f->est_paye = true; return $f; });
        return response()->json($formations);
    }

    
    public function formationsDuFormateur()
    {
        $user = Auth::user();

        
        $formations = Formation::where('user_id', $user->id)
            ->withCount('cours') 
            ->withCount('inscriptions') 
            ->latest()
            ->get();

        return response()->json($formations);
    }

      public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'niveau' => 'required|string',
            'image' => 'nullable|image|max:10240', 
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('formations', 'public');
        }

        if($request->has('dateOuverture')) {
            $data['date_ouverture'] = $request->dateOuverture;
        }

        
        $data['user_id'] = Auth::id();

        $formation = Formation::create($data);
        return response()->json($formation, 201);
    }

    
    public function show($id)
    {
        $formation = Formation::with(['user', 'cours.ressources'])->find($id);

        if (!$formation) {
            return response()->json(['success' => false, 'message' => 'Formation introuvable.'], 404);
        }

        $user = auth('sanctum')->user();
        if ($user) {
            $formation->est_paye = $formation->inscriptions()->where('user_id', $user->id)->exists();
            
            
            if ($formation->user_id == $user->id) {
                $formation->est_paye = true; 
            }
        } else {
            $formation->est_paye = false;
        }

        return response()->json($formation);
    }

    
    public function update(Request $request, $id)
    {
        $formation = Formation::findOrFail($id);

        
        if ($formation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
        
        if ($request->hasFile('image')) {
            
            if ($formation->image && File::exists(public_path('storage/'.$formation->image))) {
               
            }
            
            $path = $request->file('image')->store('formations', 'public');
            $request->merge(['image' => $path]);
        }

        $formation->update($request->all());
        return response()->json($formation);
    }

    
    public function destroy($id)
    {
        $formation = Formation::findOrFail($id);

        
        if ($formation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $formation->delete();
        return response()->json(['message' => 'Formation supprimée']);
    }

    
    public function etudiants($id)
    {
        $formation = Formation::findOrFail($id);

        
        if ($formation->user_id !== Auth::id()) {
             return response()->json(['message' => 'Non autorisé'], 403);
        }

        $etudiants = \App\Models\User::whereHas('inscriptions', function($q) use ($id){
            $q->where('formation_id', $id);
        })->get();

        return response()->json($etudiants);
    }
}