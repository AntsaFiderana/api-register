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

}
