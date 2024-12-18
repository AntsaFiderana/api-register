<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;

class UtilisateurController extends Controller
{
    public function index()
    {
        $utilisateurs=Utilisateur::all();
        
        return response()->json($utilisateurs);
    }
}
