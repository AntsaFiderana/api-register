<?php
namespace App\Mail;

use App\Models\Utilisateur;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ValidationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $utilisateur;
    public $url;

    public function __construct(Utilisateur $utilisateur, $url)
    {
        $this->utilisateur = $utilisateur;
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('Verification compte')
                    ->view('emails.validation')
                    ->with([
                        'url' => $this->url,  // Passez l'URL dans la vue
                    ]);
    }
}

