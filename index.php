<?php 
require('vendor/autoload.php');

use Symfony\Component\Dotenv\Dotenv;
use Nette\Database\Connection;

$dotenv = new Dotenv(true);
$dotenv->load(__DIR__ . '/.env');

$transport = new Swift_SmtpTransport(
                getenv('SMTP_HOST'), 
                getenv('MAIL_PORT'), 
                getenv('MAIL_ENCRYPTION')
        );
$transport->setUsername(getenv('MAIL_USER_NAME'))
            ->setPassword(getenv('MAIL_PASSWORD'));

$mailer = new Swift_Mailer($transport);

$message = new Swift_Message('Mensaje de prueba');

$message->setFrom('angel@makechtecnology.online')
        ->setTo('angeldomp49@gmail.com')
        ->setBody('Mensaje desde Swift Mailer');

$response = $mailer->send($message);

$connection = new Connection(
                "mysql:host=". getenv('DB_HOST') .";dbname=" . getenv('DB_NAME'), 
                getenv('DB_USER'), 
                getenv('DB_PASSWORD')
        );

$connection->query('INSERT INTO contact_types', [
        'name' => 'angel'
]);