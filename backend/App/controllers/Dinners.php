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
      // var_dump($restaurantes);
      $restaurante = '';

      foreach ($restaurantes as $key => $value) {
        $restaurante .=<<<html
        <option value="{$value['id_restaurante']}">{$value['nombre']}</option>
html;
      }

      View::set('anfitrion',$anfitrion);
      View::set('restaurante',$restaurante);
      View::set('restaurantes',$restaurantes);
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("dinner_work");
    }

}
