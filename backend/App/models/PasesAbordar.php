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

    public static function getDocAsist($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT pa.*, CONCAT(ra.nombre,' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo
        FROM pases_abordar pa
        INNER JOIN utilerias_asistentes ua
        ON pa.utilerias_asistentes_id = ua.utilerias_asistentes_id
        INNER JOIN registros_acceso ra
        ON ra.id_registro_acceso = ua.id_registro_acceso

        WHERE pa.utilerias_asistentes_id = $id
sql;
        return $mysqli->queryOne($query);
    }
}
