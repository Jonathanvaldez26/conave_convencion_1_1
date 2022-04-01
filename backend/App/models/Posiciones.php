<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Posiciones{


    public static function getPosicionesAll(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM posiciones
sql;

        return $mysqli->queryAll($query);
    }
}
