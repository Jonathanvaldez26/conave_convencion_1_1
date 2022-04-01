<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class UnidadNegocio{


    public static function getBuAll(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM bu
sql;

        return $mysqli->queryAll($query);
    }
}
