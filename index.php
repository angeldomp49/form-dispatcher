<?php 
require('vendor/autoload.php');

use Nette\Database\Connection;

$transport = new Swift_SmtpTransport('smtp.hostinger.com', 465, 'ssl');
$transport->setUsername('angel@makechtecnology.online')
            ->setPassword('3nitrotoluenO');

$mailer = new Swift_Mailer($transport);

$message = new Swift_Message('Mensaje de prueba');

$message->setFrom('angel@makechtecnology.online')
        ->setTo('angeldomp49@gmail.com')
        ->setBody('Mensaje desde Swift Mailer');

$response = $mailer->send($message);

$connection = new Connection("mysql:host=localhost;dbname=form_panel", "root", "");

$connection->query('INSERT INTO contact_types', [
        'name' => 'angel'
]);