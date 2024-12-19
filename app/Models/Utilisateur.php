<?php

namespace App\Models;

use App\Token\SessionParams;
use App\Token\TokenGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Utilisateur extends Model
{
    //
    public $timestamps = false;
    protected $table = 'utilisateur';
    protected $fillable = ['id','email', 'mdp', 'nom', 'isverified','dateinscription', 'tentative'];
    protected $casts = [
        'isverified' => 'boolean',  
        'tentative' => 'integer'
    ];

    public function createToken()
    {
        $token=TokenGenerator::generateToken();
        $now=Carbon::now();
        $tokenutilisateur=Tokenutilisateur::create(
            [
                'token'=>$token,
                'idutilisateur'=>$this->id,
                'daty'=>$now->toDateTimeString(),
                'expiration'=>$now->addSeconds(SessionParams::$expinscription)->toDayDateTimeString()
            ]
            );
        return $tokenutilisateur;
    }

    public function tokens()
    {
        return $this->hasMany(Tokenutilisateur::class,'idutilisateur');
    }

    public static function getToken($token)
    {
        $now=Carbon::now();

        
        $utilisateurtoken =Tokenutilisateur::where('token',$token)->first();
        
        if(!$utilisateurtoken)
        {
            return [
                'success' => false,
                'message' => "Le token $token  n\'appartient à aucun utilisateur.",
                'status'=>404
            ];
        }


        $expirationdate=Carbon::parse($utilisateurtoken["expiration"]);
     

        if($now->timestamp > $expirationdate->timestamp)
        {
            return [
                'success'=>false,
                'message'=>"Votre session a expiré",
                'status'=>404
            ];
        }

        $myuser=Utilisateur::find($utilisateurtoken["idutilisateur"]);
        return [
            'success' => true,
            'user'=> $myuser,
            'status'=>200
        ];
    }
}
