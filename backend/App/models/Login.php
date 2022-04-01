<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Login{

    public static function getById($usuario){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT ua.*, ra.nombre FROM utilerias_asistentes ua INNER JOIN registros_acceso ra WHERE ua.id_registro_acceso = ra.id_registro_acceso and ua.usuario LIKE :usuario AND contrasena LIKE :password
sql;
        $params = array(
            ':usuario'=> $usuario->_usuario,
            ':password'=>$usuario->_password
        );

        return $mysqli->queryOne($query,$params);
    }

    public static function getUser($usuario){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT ua.*, ra.* FROM utilerias_asistentes ua INNER JOIN registros_acceso ra WHERE ua.id_registro_acceso = ra.id_registro_acceso and ua.usuario = '$usuario'
sql;

        return $mysqli->queryAll($query);
    }

//     public static function getUser($usuario){
//         $mysqli = Database::getInstance(true);
//         $query =<<<sql
//         SELECT * FROM utilerias_asistentes WHERE usuario = '$usuario'
// sql;

//         return $mysqli->queryAll($query);
//     }
}
