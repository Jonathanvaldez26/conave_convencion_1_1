<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\PasesAbordar AS PasesAbordarDao;

class Passes extends Controller{

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
     <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
     <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
html;
     $extraFooter =<<<html
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <!-- Kanban scripts -->
    <script src="../../assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="../../assets/js/plugins/jkanban/jkanban.js"></script>
    <script src="../../assets/js/plugins/chartjs.min.js"></script>
    <script src="../../assets/js/plugins/fullcalendar.min.js"></script>
    <script>
        var ctx1 = document.getElementById("chart-line-1").getContext("2d");
    
        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
    
        gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.02)');
        gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors
    
        var ctx2 = document.getElementById("chart-line-2").getContext("2d");
    
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../../assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
html;

        $pases_abordar = PasesAbordarDao::getCount($_SESSION['utilerias_asistentes_id']);

        $documento = PasesAbordarDao::getDocAsist($_SESSION['utilerias_asistentes_id'])['url'];
        $documento_salida = PasesAbordarDao::getDocAsistSalida($_SESSION['utilerias_asistentes_id'])['url'];
        $nombre_completo = PasesAbordarDao::getDocAsist($_SESSION['utilerias_asistentes_id'])['nombre_completo'];
        // var_dump($nombre_completo);
        
        if($pases_abordar['count'] >= 1 ){
            //Vista principal
            View::set('nombre_completo',$nombre_completo);
            View::set('documento',$documento);
            View::set('documento_salida',$documento_salida);
            View::render("passes_all");
        }else{
            View::set('documento',$documento);
            View::set('header',$this->_contenedor->header($extraHeader));
            View::set('footer',$this->_contenedor->footer($extraFooter));
            View::render("passes_work");
        }
      
    }
}
