<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordLinkMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;
    public $email;
    public $name;
    public $actionText;

    public function __construct($data)
    {
        
        $this->token = $data['token'];
        $this->email = $data['email'];
        $this->name = $data['name'];
        $this->actionText = $data['actionText'];
    }

    public function build()
    {
        return $this->subject('Reset Password')
                    ->view('emails.reset_password_link');
    }
}
