<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
