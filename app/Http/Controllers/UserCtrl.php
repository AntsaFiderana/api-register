<?php

namespace App\Http\Controllers;

use App\Mail\ValidationEmail;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Info(
 *     title="Mon API",
 *     description="Description de l'API",
 *     version="1.0.0"
 * )
 */
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
    /**
     * @OA\Get(
     *     path="/api/validationinscription/{token}",
     *     summary="Valider l'email de l'utilisateur",
     *     tags={"Utilisateur"},
     *     @OA\Parameter(
     *         name="token",
     *         in="path",
     *         required=true,
     *         description="Token d'activation de l'utilisateur",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur confirmé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Utilisateur user@example.com a bien ete confirme")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Token invalide",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Token invalide")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur interne du serveur",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Une erreur interne s'est produite.")
     *         )
     *     )
     * )
     */
    public function validateEmail($token)
    {
        $result=Utilisateur::getToken($token);
        if(!$result["success"])
        {
            return response()->json($result);
        }
        $verifieduser=$result["user"];
        $verifieduser->isverified=true;
        $verifieduser->save();
        return response()->json([
                'success'=>true,
                'message'=>"Utilisateur $verifieduser->email a bien ete confirme ",
                'status'=>200
            ]
            ,200);

    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/utilisateurs",
     *     summary="Créer un nouvel utilisateur",
     *     tags={"Utilisateur"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "nom", "mdp"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="nom", type="string", example="Nom Utilisateur"),
     *             @OA\Property(property="mdp", type="string", format="password", example="password123"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Un e-mail de validation a été envoyé.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erreur de validation des données."),
     *             @OA\Property(property="messages", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur interne du serveur",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Une erreur interne s'est produite."),
     *             @OA\Property(property="message", type="string", example="Détails de l'erreur")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email|unique:utilisateur,email',
                'nom' => 'required|string',
                'mdp1' => 'required|string|min:6',
                'mdp2'=>'required|string|min:6',

            ]);

            $utilisateur = Utilisateur::create([
                'email' => $request->email,
                'nom' => $request->nom,
                'mdp' => bcrypt($request->mdp1),
                'dateinscription'=>Carbon::now()->toDateTimeString(),
                 'isverified'=>false
            ]);

            $tokenutilisateur=$utilisateur->createToken();

            $url = route('confirmEmail', ['token' => $tokenutilisateur->token]);
            echo $url;

            Mail::to($utilisateur->email)->send(new ValidationEmail($utilisateur,$url));


            return response()->json([
                'message' => 'Un e-mail de validation a été envoyé. Veuillez vérifier votre boîte de réception.',
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
