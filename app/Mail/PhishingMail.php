<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use League\Flysystem\Config;
use Modules\Auth\Entities\Core\User;
use App\Mail\PhishingMail;
use Modules\Phishing\Entities\PhishingEmail;

class PhishingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var User
     */
    public $user;

    /**
     * The url
     *
     * @var String
     */
     public $url;


    /**
     * Create a New message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->url = "http://mu-edu-sa.tk/phishing.php?mail=" . $user->user_mail;

        config([
            'mail.host' => 'smtp.gmail.com',
            'mail.username' => 'mu.edu.sa5@gmail.com',
            'mail.password' => 'Aa10203040'
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //change email config
        $mailTransport = app()->make('mailer')->getSwiftMailer()->getTransport();
        if ($mailTransport instanceof \Swift_SmtpTransport) {
            /** @var \Swift_SmtpTransport $mailTransport */
            $mailTransport->setUsername('mu.edu.sa5@gmail.com');
            $mailTransport->setPassword('Aa10203040');
            $mailTransport->setHost('smtp.gmail.com');
        }

        PhishingEmail::create(['user_id' => $this->user->user_id, 'sent_at' => date('Y-m-d')]);

        return $this->subject('تنويه من الخدمات الإلكترونية')
                    ->from('es.mu.edu.sa@gmail.com', 'الخدمات الإلكترونية')
                    ->view('mailers.phishing');
    }
}
