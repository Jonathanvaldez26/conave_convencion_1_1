<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\Controller;
use \App\models\Home AS HomeDao;
use \App\models\Covid AS CovidDao;
use \App\models\Vaccination AS VaccinationDao;
use \App\models\PasesAbordar AS PasesAbordarDao;
use \App\models\Notificaciones AS NotificacionesDao;



class Home extends Controller{

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
      <link id="pagestyle" href="/assets/css/style.css" rel="stylesheet" />
html;

        //Modulo Comprobante de vacunacion
        $comprobante_vacunacion = VaccinationDao::getCountHome($_SESSION['utilerias_asistentes_id']);
        //descomentar esto cuando nos diga janeth
         if($comprobante_vacunacion['count'] >= 1 ){
         $active_pruebas_covid = "Disponible <i class=\"fa fa-check-circle me-sm-0\" style=\"color: #01a31c\"></i>";
         }else{
          $active_pruebas_covid = "En espera <i class=\"fa fa-clock me-sm-0\" style=\"color: #8a6d3b\"></i>";
        }

        //modulo pases de abordar
        $pruebas_covid = CovidDao::getCount($_SESSION['utilerias_asistentes_id']);
        // var_dump($pruebas_covid);
        if($pruebas_covid['count'] >= 1 ){
        $active_pase_abordar = "Disponible <i class=\"fa fa-check-circle me-sm-0\" style=\"color: #01a31c\"></i>";
        }else{
          $active_pase_abordar = "En espera <i class=\"fa fa-clock me-sm-0\" style=\"color: #8a6d3b\"></i>";
        }

        //modulo modal tallas
        $talla_playera = HomeDao::getTallaPlayera($_SESSION['utilerias_asistentes_id'])[0]['talla_playera'];
        if ($talla_playera == '' || $talla_playera == NULL || $talla_playera == 'NULL' ) {
          $tiene_talla = 'no_tiene';
        } else {
          $tiene_talla = 'tiene';
        }
       
        $card_permisos = HomeDao::getCountByUser($_SESSION['utilerias_asistentes_id']);


        $footer =<<<html
        <!-- jQuery -->

          <script>
            function catalogos(params) {
                var catalogo = document.getElementById("catalogos");

                if (catalogo.hasAttribute('hidden')) {
                    catalogo.removeAttribute('hidden');
                } else {
                    catalogo.setAttribute('hidden','')
                }
            }

            function utilerias(params) {
                var utileria = document.getElementById("utilerias");

                if (utileria.hasAttribute('hidden')) {
                    utileria.removeAttribute('hidden');
                } else {
                    utileria.setAttribute('hidden','')
                }
            }
        </script>

        <script src="/js/jquery.min.js"></script>
        <!--   Core JS Files   -->
        <script src="../../assets/js/core/popper.min.js"></script>
        <script src="../../assets/js/core/bootstrap.min.js"></script>
        <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="../../assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="../../assets/js/plugins/jkanban/jkanban.js"></script>
        <script src="../../assets/js/plugins/chartjs.min.js"></script>
        <script src="../../assets/js/plugins/threejs.js"></script>
        <script src="../../assets/js/plugins/orbit-controls.js"></script>
        
      <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
      <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../../assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>


        <!-- VIEJO INICIO -->
        <script src="/js/jquery.min.js"></script>
       
        <script src="/js/custom.min.js"></script>

        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <script src="/js/login.js"></script>
        <!-- VIEJO FIN -->

        <!--   Core JS Files   -->
        <script src="../../assets/js/core/popper.min.js"></script>
        <script src="../../assets/js/core/bootstrap.min.js"></script>
        <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="../../assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="../../assets/js/plugins/jkanban/jkanban.js"></script>
        <script src="../../assets/js/plugins/chartjs.min.js"></script>
        <script src="../../assets/js/plugins/threejs.js"></script>
        <script src="../../assets/js/plugins/orbit-controls.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <script src = "http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
html;

        View::set('active_pruebas_covid',$active_pruebas_covid);
        View::set('active_pase_abordar',$active_pase_abordar);
        View::set('tiene_talla',$tiene_talla);
        View::set('talla_playera',$talla_playera);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($footer));
        //View::set('tabla',$tabla);
        View::render("principal_all");
    }

    public function NoCargaPickup(){
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
        <title>
            Convecnion 2022
        </title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="../../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        
        
        
        

html;
        $extraFooter =<<<html
     
        <script src="/js/jquery.min.js"></script>
        <!--   Core JS Files   -->
        <script src="../../assets/js/core/popper.min.js"></script>
        <script src="../../assets/js/core/bootstrap.min.js"></script>
        <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="../../assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="../../assets/js/plugins/jkanban/jkanban.js"></script>
        <script src="../../assets/js/plugins/chartjs.min.js"></script>
        <script src="../../assets/js/plugins/threejs.js"></script>
        <script src="../../assets/js/plugins/orbit-controls.js"></script>
        
      <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
      <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../../assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>


        <!-- VIEJO INICIO -->
        <script src="/js/jquery.min.js"></script>
       
        <script src="/js/custom.min.js"></script>

        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <script src="/js/login.js"></script>
        <!-- VIEJO FIN -->

        <!--   Core JS Files   -->
        <script src="../../assets/js/core/popper.min.js"></script>
        <script src="../../assets/js/core/bootstrap.min.js"></script>
        <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="../../assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="../../assets/js/plugins/jkanban/jkanban.js"></script>
        <script src="../../assets/js/plugins/chartjs.min.js"></script>
        <script src="../../assets/js/plugins/threejs.js"></script>
        <script src="../../assets/js/plugins/orbit-controls.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <script src = "http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

html;

        View::set('header',$extraHeader);
        View::set('footer',$extraFooter);
        View::render("code");
    }

    function getNotificaciones(){
      $id_asis = $_POST['id'];
      $notificaciones = NotificacionesDao::getNotificaciones($id_asis);
      echo json_encode($notificaciones);
    }

    function leerNotif(){
      $id_notif = $_POST['id'];
      $noficacionLeida = NotificacionesDao::updateStatusNotif($id_notif);

      if($noficacionLeida){
        echo 'success';
      }else{
        echo 'fail';
      }
    }

    function getItinerario(){
      $id_asis = $_POST['id'];
      $asistenteItinerario = HomeDao::getItinerarioAsistente($id_asis)[0];
      echo json_encode($asistenteItinerario);
    }


}
