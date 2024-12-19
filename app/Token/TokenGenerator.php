<?php 
namespace App\Token;
use Illuminate\Support\Str;
class TokenGenerator 
{
	public static function generateToken()
	{
		$token = Str::random(60);
		return $token;
	}
}
?>