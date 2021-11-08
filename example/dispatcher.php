<?php 

use Facades\Mail;
use Facades\Database;
use Facades\Session;

require_once(__DIR__ .'/../vendor/autoload.php');

Session::saveOlds();

Mail::default("Mensaje de prueba")
    ->setTo($_POST['email'])
    ->send();

Database::default()
    ->setTable('records')
    ->insert([
        'name' => $_POST['name'],
        'email' => $_POST['email']
    ]);

session('success', true);

back();