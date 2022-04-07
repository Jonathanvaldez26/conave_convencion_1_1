<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\Login as LoginDao;
use \App\models\Register as RegisterDao;
use \App\models\LineaGeneral as LineaGeneralDao;
use \App\models\Data as DataDao;

class Dinners extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    public function getUsuario(){
      return $this->__usuario;
    }

    public function index() {
     $extraHeader =<<<html
     <script src="/js/jquery.min.js"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <script src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <style>
        .logo{
          width:100%;
          height:150px;
          margin: 0px;
          padding: 0px;
        }
      </style>
html;

      $anfitrion = DataDao::getAnfitrion($_SESSION['utilerias_asistentes_id']);
      $restaurantes = DataDao::getRestaurantes();
      $restaurante = '';

      foreach ($restaurantes as $key => $value) {
        $restaurante .=<<<html
        <option value="{$value['id_restaurante']}">{$value['nombre']}</option>
html;
      }

      $rests = DataDao::getRestaurantes();
      $rest = '';

      foreach ($rests as $key => $value) {
        $rest .=<<<html
        <input id="{$value['id_restaurante']}" value="{$value['capacidad']}" hidden readonly>
html;
      }

      $asistentes = DataDao::getAsistentes();
      $asistente = '';

      foreach ($asistentes as $key => $value) {
        $asistente .=<<<html
        <option value="{$value['utilerias_asistentes_id']}">{$value['nombre']} {$value['segundo_nombre']} {$value['apellido_paterno']} {$value['apellido_materno']} </option>
html;
      }

      // $cupo = DataDao::getNumCupo();

      View::set('anfitrion',$anfitrion);
      View::set('restaurante',$restaurante);
      View::set('restaurantes',$restaurantes);
      View::set('rest',$rest);
      View::set('rests',$rests);
      View::set('asistente',$asistente);
      View::set('asistentes',$asistentes);
      // View::set('cupo',$cupo);
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("dinner_work");
    }

    public function agregarCena(){

      $documento = new \stdClass();
      $documento2 = new \stdClass();
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $id_para_anfitrion = $_SESSION['utilerias_asistentes_id'];
        $id_restaurante = $_POST['restaurante'];
        $clave_anfitrion = $this->generateRandomString(8);
        $cantidad = $_POST['cantidad'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];

        $documento->_id_para_anfitrion = $id_para_anfitrion;
        $documento->_id_restaurante = $id_restaurante;
        $documento->_clave_anfitrion = $clave_anfitrion;
        $documento->_cantidad = $cantidad;
        $documento->_fecha = $fecha;
        $documento->_hora = $hora;

        $id = DataDao::insertAnfitrion($documento);
        
        if ($id) {
            // echo "success";
            
              /////----------Documento2
              $anfitrion = DataDao::getAnfitrionByUAId($_SESSION['utilerias_asistentes_id'],$clave_anfitrion);

              $clave_reservacion = $this->generateRandomString(8);
              $id_anfitrion = $anfitrion[0]['id_anfitrion'];

              $asistente1 = $_POST['asistente1'];
              $asistente2 = $_POST['asistente2'];
              $asistente3 = $_POST['asistente3'];
              $asistente4 = $_POST['asistente4'];
              $asistente5 = $_POST['asistente5'];

              $documento2->_clave_reservacion = $clave_reservacion;
              $documento2->_id_anfitrion = $id_anfitrion;
              
              // var_dump($asistente1);
              // var_dump($asistente2);
              // var_dump($asistente3);
              // var_dump($asistente4);
              // var_dump($asistente5);
              // $documento2->_asistente1 = $asistente1;
              // $documento2->_asistente2 = $asistente2;
              // $documento2->_asistente3 = $asistente3;
              // $documento2->_asistente4 = $asistente4;
              // $documento2->_asistente5 = $asistente5;

              $capacidad = DataDao::getRestaurantesById($id_restaurante)[0]['capacidad'];
              $cupo = DataDao::getNumCupo($id_restaurante)['num'];
              // var_dump($capacidad);

              $cupo_t =$cupo+$cantidad;
              if ($cupo < $capacidad && $cupo_t <= $capacidad) {
                $msg = 'success';
                if ($asistente1 != NULL && $asistente1 != 'NULL'){
                  $asistente = $asistente1;
                  $documento2->_asistente = $asistente;
                  // var_dump($documento2);
                  $id_assist1 = DataDao::insertReservacion($documento2);
                }
  
                if ($asistente2 != NULL && $asistente2 != 'NULL'){
                  $asistente = $asistente2;
                  $documento2->_asistente = $asistente;
                  $id_assist2 = DataDao::insertReservacion($documento2);
                }
  
                if ($asistente3 != NULL && $asistente3 != 'NULL'){
                  $asistente = $asistente3;
                  $documento2->_asistente = $asistente;
                  $id_assist3 = DataDao::insertReservacion($documento2);
                }
  
                if ($asistente4 != NULL && $asistente4 != 'NULL'){
                  $asistente = $asistente4;
                  $documento2->_asistente = $asistente;
                  $id_assist4 = DataDao::insertReservacion($documento2);
                }
  
                if ($asistente5 != NULL && $asistente5 != 'NULL'){
                  $asistente = $asistente5;
                  $documento2->_asistente = $asistente;
                  $id_assist5 = DataDao::insertReservacion($documento2);
                }
  
                
  
                if ($id_assist1 || $id_assist2 || $id_assist3 || $id_assist4  || $id_assist5) {
                    echo $msg;
                    //header("Location: /Home");
                } else {
                    echo "fail";
                    // header("Location: /Home/");
                }
              } else {
                echo "fail_cupo";
              }

              
        } else {
            echo "fail";
            // header("Location: /Home/");
        }
       
        
      } else {
        echo 'fail REQUEST';
      }
    }

    function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
}
