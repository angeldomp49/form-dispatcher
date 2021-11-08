<?php 

use Facades\Mail;
use Facades\Database;
use Facades\Session;

require_once(__DIR__ .'/../vendor/autoload.php');

Session::saveOlds();

try{
    Mail::default("Mensaje de prueba")
        ->setTo($_POST['email'])
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