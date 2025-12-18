<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use Illuminate\Http\JsonResponse;

class ReferenceController extends Controller
{
    public function indexPays(): JsonResponse
    {
        // On récupère tout, trié par nom
        $pays = Pays::orderBy('nom')->get();
        return response()->json($pays);
    }
}