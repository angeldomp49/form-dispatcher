<?php 

use Facades\Mail;
use Facades\Database;
use Facades\Session;
use Facades\Template;
use Facades\ReCaptcha;

require_once(__DIR__ .'/../vendor/autoload.php');

Session::saveOlds();

try{

    $recaptcha = ReCaptcha::default()
                    ->error(function(){
                        throw new \Exception("Error ReCaptcha", 1);
                    })
                    ->check($_POST['input_recaptcha'], $_SERVER['REMOTE_ADDR']);


    $responseHTML = Template::render('mail.php', [ 'email' => $_POST['email'] ]);

    Mail::default("Mensaje de prueba")
        ->setTo($_POST['email'])
        ->setBody($responseHTML, 'text/html')
        ->send();

    Database::default()
        ->setTable('records')
        ->insert([
            'name' => $_POST['name'],
            'email' => $_POST['email']
        ]);
}
catch(\Exception $e){
    session('error', true);
    session('message', 'Ha ocurrido un error');
    back();
}

session('success', true);
session('message', 'exito');
back();