<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class PasesAbordar{


    public static function getCount($id){

        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(*) as count FROM pases_abordar WHERE utilerias_asistentes_id = $id ORDER BY id_pase_abordar ASC;
sql;
        return $mysqli->queryOne($query);
    }
}
