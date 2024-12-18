<?php

namespace App\Http\Controllers;

use App\Mail\ValidationEmail;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class UserCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
    * 
    * Validation email
     */
    /*public function validateEmail($token)
    {
        $myuser=Utilisateur::where();
    }*/
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email|unique:utilisateur,email',
                'nom' => 'required|string',
                'mdp1' => 'required|string|min:6|confirmed',
                'mdp2'=>'required|string|min:6|confirmed',
            ]);
    
            $utilisateur = Utilisateur::create([
                'email' => $request->email,
                'nom' => $request->nom,
                'mdp' => bcrypt($request->mdp1),
                'dateinscription'=>'0'
            ]);


            $url = route('', ['id' => $utilisateur->id]);
            //Mail::to($utilisateur->email)->send(new ValidationEmail($utilisateur,$url));
            return response()->json([
                'message' => 'Un e-mail de validation a été envoyé. Veuillez vérifier votre boîte de réception.',
                'user' => $utilisateur,
                'status' => 200,
            ], 200);
         
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Erreur de validation des données.',
                'messages' => $e->errors(),
            ], 422);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur interne s\'est produite.',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
