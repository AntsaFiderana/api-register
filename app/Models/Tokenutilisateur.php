<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tokenutilisateur extends Model
{
    //
    public $timestamps = false;
    protected $table='tokenutilisateur';
    protected $fillable=['id','expiration','token','daty','idutilisateur'];

}
