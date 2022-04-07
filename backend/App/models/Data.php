<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Data {

  public static function update($user){
    $mysqli = Database::getInstance(true);
    $query=<<<sql
    UPDATE registros_acceso SET id_bu = :id_bu, id_posicion = :id_posicion, id_residencia = :id_residencia, id_ciudades = :id_ciudades, id_cp = :id_cp, id_linea_principal = :id_linea_principal, numero_empleado = :numero_empleado, nombre = :nombre, segundo_nombre = :segundo_nombre, apellido_materno = :apellido_materno, apellido_paterno = :apellido_paterno, genero = :genero, fecha_nacimiento = :fecha_nacimiento, telefono = :telefono, actividad = :actividad, alergias = :alergias, alergias_otro = :alergias_otro, alergia_medicamento = :alergia_medicamento, alergia_medicamento_cual = :alergia_medicamento_cual, restricciones_alimenticias = :restricciones_alimenticias, restricciones_alimenticias_cual = :restricciones_alimenticias_cual, politica = :politica  WHERE email = :email;
sql;
    $parametros = array(
      ':id_linea_principal'=>$user->_linea_principal,
      ':id_bu'=>$user->_bu,
      ':id_posicion'=>$user->_posicion,
      ':id_residencia'=>$user->_residencia,
      ':id_ciudades'=>$user->_ciudades,
      // ':id_aeropuerto'=>$user->_aeropuerto,
      ':id_cp'=>$user->_cp,
      ':nombre'=>$user->_nombre,
      ':numero_empleado'=> $user->_numero_empleado,
      ':segundo_nombre'=>$user->_segundo_nombre,
      ':apellido_paterno'=>$user->_apellido_paterno,
      ':apellido_materno'=>$user->_apellido_materno,
      ':genero'=>$user->_genero,
      ':fecha_nacimiento'=>$user->_fecha_nacimiento,
      ':telefono'=>$user->_telefono,
      ':actividad'=>$user->_actividad,
      //':talla_playera'=>$user->_talla,
      ':alergias'=>$user->_alergias,
      ':alergias_otro'=>$user->_alergia_otro,
      ':alergia_medicamento' =>$user->_alergia_medicamento,
      ':alergia_medicamento_cual' =>$user->_alergia_medicamento_cual,
      ':restricciones_alimenticias' =>$user->_restricciones_alimenticias,
      ':restricciones_alimenticias_cual' =>$user->_restricciones_alimenticias_cual,
      ':politica' => $user->_politica,
      ':email'=>$user->_email
      
    );


      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $user->_administrador_id;
      // UtileriasLog::addAccion($accion);
      return $mysqli->update($query, $parametros);
  }

  public static function updateInAdmin($user){
    $mysqli = Database::getInstance(true);
    $query=<<<sql
    UPDATE registros_acceso SET nombre = :nombre, segundo_nombre = :segundo_nombre, apellido_materno = :apellido_materno, apellido_paterno = :apellido_paterno, genero = :genero, fecha_nacimiento = :fecha_nacimiento, telefono = :telefono, alergias = :alergias, alergias_otro = :alergias_otro, alergia_medicamento = :alergia_medicamento, alergia_medicamento_cual = :alergia_medicamento_cual, restricciones_alimenticias = :restricciones_alimenticias, restricciones_alimenticias_cual = :restricciones_alimenticias_cual  WHERE email = :email;

sql;
    $parametros = array(
      
      ':nombre'=>$user->_nombre,
      ':segundo_nombre'=>$user->_segundo_nombre,
      ':apellido_paterno'=>$user->_apellido_paterno,
      ':apellido_materno'=>$user->_apellido_materno,
      ':genero'=>$user->_genero,
      ':fecha_nacimiento'=>$user->_fecha_nacimiento,
      ':telefono'=>$user->_telefono,
      ':alergias'=>$user->_alergias,
      ':alergias_otro'=>$user->_alergia_otro,
      ':alergia_medicamento' =>$user->_alergia_medicamento,
      ':alergia_medicamento_cual' =>$user->_alergia_medicamento_cual,
      ':restricciones_alimenticias' =>$user->_restricciones_alimenticias,
      ':restricciones_alimenticias_cual' =>$user->_restricciones_alimenticias_cual,
	  //':talla' =>$user->_talla,
      ':email'=>$user->_email
      
    );


      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $user->_administrador_id;
      // UtileriasLog::addAccion($accion);
      return $mysqli->update($query, $parametros);
  }


  public static function insert($register)
    {
        $mysqli = Database::getInstance();
        $query = <<<sql
        INSERT INTO utilerias_asistentes VALUES(null,:id_registro_acceso,:usuario,:contrasena,:politica,1,NOW())                        
sql;

        $parametros = array(
            ':id_registro_acceso' => $register->_id_registro_acceso,
            ':usuario' => $register->_email,
            ':contrasena' => $register->_password,
            ':politica' => $register->_politica
        );

        $id = $mysqli->insert($query, $parametros);
        $accion = new \stdClass();
        $accion->_sql = $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        return $id;
    }
 
    public static function getAnfitrion($id){

      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM utilerias_asistentes ua 
      JOIN registros_acceso ra
      ON ra.id_registro_acceso = ua.id_registro_acceso
      WHERE ua.utilerias_asistentes_id = $id
sql;
      return $mysqli->queryOne($query);
  }

  public static function getRestaurantes(){

    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT * FROM restaurante
sql;
    return $mysqli->queryAll($query);
  }
  public static function getRestaurantesById($id){

    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT * FROM restaurante WHERE id_restaurante = $id
sql;
    return $mysqli->queryAll($query);
  }

  public static function getAnfitrionByUAId($id,$clave){

    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT * FROM anfitrion WHERE utilerias_asistentes_id = $id and clave = '$clave'
sql;
    return $mysqli->queryAll($query);
  }

  public static function getAsistentes(){

    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT * FROM registros_acceso ra
    INNER JOIN utilerias_asistentes ua
    ON ra.id_registro_acceso = ua.id_registro_acceso
sql;
    return $mysqli->queryAll($query);
  }

  public static function getNumCupo($id){

    $mysqli = Database::getInstance(true);
    $query =<<<sql
    SELECT count(*) as numero_ocupantes_en_restaurante FROM reservacion re 
    INNER JOIN anfitrion an
    ON re.id_anfitrion = an.id_anfitrion
    WHERE an.id_restaurante = $id
sql;
    return $mysqli->queryOne($query);
  }

  public static function insertAnfitrion($info)
    {
        $mysqli = Database::getInstance();
        $query = <<<sql
        INSERT INTO anfitrion 
              (clave, 
              utilerias_asistentes_id, 
              cantidad, 
              fecha, 
              hora, 
              fecha_alta, 
              id_restaurante,status)
        VALUES(
              :clave_anfitrion,
              :id_para_anfitrion,
              :cantidad,
              :fecha,
              :hora,
              NOW(),
              :id_restaurante,1)                        
sql;

        $parametros = array(
            ':id_restaurante' => $info->_id_restaurante,
            ':clave_anfitrion' => $info->_clave_anfitrion,
            ':id_para_anfitrion' => $info->_id_para_anfitrion,
            ':cantidad' => $info->_cantidad,
            ':fecha' => $info->_fecha,
            ':hora' => $info->_hora,
        );

        $id = $mysqli->insert($query, $parametros);
        $accion = new \stdClass();
        $accion->_sql = $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        return $id;
    }

    public static function insertReservacion($info)
    {
        $mysqli = Database::getInstance();
        $query = <<<sql
        INSERT INTO reservacion 
              (clave, 
              id_anfitrion, 
              utilerias_asistentes_id)
        VALUES(:clave_reservacion,
              :id_anfitrion,:asistente)                        
sql;

        $parametros = array(
            ':clave_reservacion' => $info->_clave_reservacion,
            ':asistente' => $info->_asistente,
            ':id_anfitrion' => $info->_id_anfitrion,
        );

        $id = $mysqli->insert($query, $parametros);
        $accion = new \stdClass();
        $accion->_sql = $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        return $id;
    }
}
