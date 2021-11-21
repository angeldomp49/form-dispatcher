<?php 

use Facades\Mail;
use Facades\Database;
use Facades\Session;
use Facades\Template;

require_once(__DIR__ .'/../vendor/autoload.php');

Session::saveOlds();

try{

    $responseHTML = Template::render(__DIR__ . '/mail.php', [ 'email' => $_POST['email'] ]);

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