<?php 
namespace Facades;

use Nette\Database\Connection;
use Facades\EnvLoader;

class Database extends Connection{

    public String $table = "";

    public static function default(){
        EnvLoader::load();
        return new self(
            "mysql:host=". getenv('DB_HOST') .";dbname=" . getenv('DB_NAME'), 
            getenv('DB_USER'), 
            getenv('DB_PASSWORD')
        );
    }

    public function setTable( String $tableName){
        $this->table = $tableName;
        return $this;
    }

    public function insert( Array $records = [] ){
        if(empty($records)){
            return;
        }

        $this->query('INSERT INTO ' . $this->table , $records);
    }
}