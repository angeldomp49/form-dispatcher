<?php 
namespace Facades;

use Facades\EnvLoader;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_SmtpTransport;

class Mail extends Swift_Message{

    public Swift_Mailer $mailer;

    public static function default( String $subject = "" ){
        $instance = new self( $subject );
        $instance->defaultMailer();
        $instance->setFrom(getenv('MAIL_USER_NAME'));
        return $instance;
    }

    public function send(){
        $this->mailer->send($this);
    }

    public function defaultMailer(){
        EnvLoader::load();

        $transport = new Swift_SmtpTransport(
            getenv('SMTP_HOST'), 
            getenv('MAIL_PORT'), 
            getenv('MAIL_ENCRYPTION')
        );

        $transport->setUsername(getenv('MAIL_USER_NAME'))
                ->setPassword(getenv('MAIL_PASSWORD'));

        $this->mailer = new Swift_mailer($transport);
    }

}