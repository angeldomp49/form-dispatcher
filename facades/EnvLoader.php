<?php 
namespace Facades;

use Symfony\Component\Dotenv\Dotenv;

class EnvLoader{
    public static function load(){
        $dotenv = new Dotenv(true);
        $dotenv->load(__DIR__ . '/../.env');
    }
}