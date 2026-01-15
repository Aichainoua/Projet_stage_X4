<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

class RessourceController extends Controller
{
    
    public function store(Request $request, $formationId)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,mp4,mov,webm,avi,mkv|max:102400',
            'cours_id' => 'required|integer'
        ]);

        $file = $request->file('file');
        
        
        $filename = time() . '_' . $file->getClientOriginalName();

        
        $destinationPath = public_path('cours_files');
        $file->move($destinationPath, $filename);

        $mimeType = $file->getClientMimeType(); 
        $type = str_contains($mimeType, 'pdf') ? 'pdf' : 'video';

       
        $ressource = Ressource::create([
            'cours_id'       => $request->cours_id,
            'titre'          => $file->getClientOriginalName(),
            'type'           => $type,
            'chemin_fichier' => '/cours_files/' . $filename 
        ]);

        return response()->json($ressource, 201);
    }

    
    public function destroy($id)
    {
        $ressource = Ressource::findOrFail($id);

       
        $fullPath = public_path($ressource->chemin_fichier);

       
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        $ressource->delete();

        return response()->json(['message' => 'Ressource supprimée']);
    }
}