<?php

namespace App\controllers;

use \Core\View;
use \Core\MasterDom;
use \App\models\Register as RegisterDao;
use \App\models\LineaGeneral as LineaGeneralDao;
use \App\models\UnidadNegocio as UnidadNegocioDao;
use \App\models\Posiciones as PosicionesDao;
use \App\models\Data as DataDao;
use \App\controllers\Mailer;
use \App\controllers\Contenedor;
use App\models\UnidadNegocio;
use Core\Controller;

class Register
{
    private $_contenedor;

    public function getUsuario()
    {
        return $this->__usuario;
    }

    public function index()
    {
        $extraHeader = <<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
        <title>
            Registro Conave
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
        <!--script src="../../../assets/js/plugins/choices.min.js"></script-->

        
        
        

html;
        $extraFooter = <<<html
     
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
       <!--   Core JS Files   -->
          <script src="../../../assets/js/core/popper.min.js"></script>
          <script src="../../../assets/js/core/bootstrap.min.js"></script>
          <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/multistep-form.js"></script>
          <script src="../../../assets/js/plugins/choices.min.js"></script>
          <script type="text/javascript" wfd-invisible="true">
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const example = new Choices(element, {});
            }
            var choicesTags = document.getElementById('choices-tags');
            var color = choicesTags.dataset.color;
            if (choicesTags) {
                const example = new Choices(choicesTags, {
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                addItems: true,
                classNames: {
                    item: 'badge rounded-pill choices-' + color + ' me-2'
                }
                });
            }
        </script>
          <!-- Kanban scripts -->
          <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
          <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
           

        <script>
            $(document).ready(function(){
                $('#confirm_email').attr("disabled", true);
                $.validator.addMethod("checkUserCorreo",function(value, element) {
                  var response = false;
                    $.ajax({
                        type:"POST",
                        async: false,
                        url: "/Register/isUserValidateUser",
                        data: {email: $("#email").val()},
                        success: function(data) {
                            if(data=="true"){
                                $('#btn_registro_email').attr("disabled", false);
                                $('#confirm_email').attr("disabled", false);
                                $('#email').attr("disabled", true);

                                response = true;
                            }else{
                                $('#btn_registro_email').attr("disabled", true);
                                $('#confirm_email').attr("disabled", true);
                                document.getElementById("confirm_email").value = "";
                                
                            }
                        }
                    });

                    return response;
                },"<b >Usted no está registrado en la Base de Datos CONAVE 2022 ó ya se registro previamente en la plataforma verifique su información.</b>");

                $("#email_form").validate({
                   rules:{
                        email:{
                            required: true,
                            checkUserCorreo: true
                        },
                        confirm_email:{
                            required: true,
                            equalTo:"#email"
                        }
                    },
                    messages:{
                        email:{
                            required: "Este campo es requerido",
                        },
                        confirm_email:{
                            required: "Este campo es requerido",
                            equalTo: "El Correo Eléctronico no coincide",
                        }
                    }
                });
                

            });
            
        </script>
       
html;
        View::set('header', $extraHeader);
        View::set('footer', $extraFooter);
        View::render("Register");
    }

    public function Success()
    {


        $register = new \stdClass();

        $email = $_POST['confirm_email'];
        $register->_email = $email;

        $codigo_rand = $this->generateRandomString();
        $register->_code = $codigo_rand;

        $id = RegisterDao::update($register);
        if ($id >= 1) {
            $msg = [
                'email' => $register->_email,
                'code' =>  $register->_code
            ];

            $mailer = new Mailer();
            $mailer->mailer($msg);

            $this->code($register->_email);
        } else {
            // echo "holaaaaa";
            // exit();
            $this->code500();
            //$this->Success();
            //$this->alerta($id,'error',$method_pay, $name_register);
        }
    }

    public function alerta($id, $parametro, $type_deposit, $name_register)
    {

        $pay = '';

        if ($parametro == 'add') {
            if ($type_deposit == 'paypal') {
                $pay = 'CREDIT OR DEBIT CARD';
                $name = $name_register;
                $message_pay = 'Important note: Please include the reference provided by this system in the field "Concepto 
                de pago" as per instructions above. The payment reference must be entered in capital 
                letters. Do not add any spaces between names or include any other punctuation marks, as 
                this may affect your bank transfer confirmation.';
            }
        }

        if ($parametro == "error") {
            $mensaje = "Al parecer ha ocurrido un problema";
        }

        View::set('pay', $pay);
        View::set('message_pay', $message_pay);
        View::set('name', $name);
        View::render("alerta");
    }

    public function code($email, $alerta = null)
    {
        $extraHeader = <<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
        <title>
            Registro Conave
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
        $extraFooter = <<<html
     
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
       <!--   Core JS Files   -->
          <script src="../../../assets/js/core/popper.min.js"></script>
          <script src="../../../assets/js/core/bootstrap.min.js"></script>
          <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/multistep-form.js"></script>
         
          <!-- Kanban scripts -->
          <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
          <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
          <script>
            $(document).ready(function(){
                $.validator.addMethod("checkUserCorreo",function(value, element) {
                  var response = false;
                    $.ajax({
                        type:"POST",
                        async: false,
                        url: "/Register/isUserValidate",
                        data: {email: $("#email").val()},
                        success: function(data) {
                            if(data=="true"){
                                $('#btn_registro_email').attr("disabled", false);
                                $('#confirm_email').attr("disabled", false);
                                $('#email').attr("disabled", true);
                                response = true;
                            }else{
                                $('#btn_registro_email').attr("disabled", true);
                                $('#confirm_email').attr("disabled", true);
                                document.getElementById("confirm_email").value = "";
                            }
                        }
                    });

                    return response;
                },"Usted no está registrado en la Base de Datos CONAVE 2022, verifique con su área y reintente.");

                $("#email_form").validate({
                   rules:{
                        email:{
                            required: true,
                            checkUserCorreo: true
                        },
                        confirm_email:{
                            required: true,
                            equalTo:"#email"
                        }
                    },
                    messages:{
                        email:{
                            required: "Este campo es requerido",
                        },
                        confirm_email:{
                            required: "Este campo es requerido",
                            equalTo: "El Correo Eléctronico no coincide",
                        }
                    }
                });

            });
          
            var uno = document.getElementById("uno"),
                dos = document.getElementById("dos"),
                tres = document.getElementById("tres"),
                cuatro = document.getElementById("cuatro");

            uno.onkeyup = function() {
                if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
                    dos.focus();
                }
            }

            dos.onkeyup = function() {
                if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
                    tres.focus();
                }
            }
            tres.onkeyup = function() {
                if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
                    cuatro.focus();
                }
            }
           
        </script>
      
html;


        $code = $email;
        View::set('header', $extraHeader);
        View::set('footer', $extraFooter);
        View::set('code', $code);
        View::set('alerta', $alerta);
        View::render("code");
    }

    public function codeRecoveryPass($email, $alerta = null)
    {
        $extraHeader = <<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
        <title>
            Registro Conave
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
        $extraFooter = <<<html
     
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
       <!--   Core JS Files   -->
          <script src="../../../assets/js/core/popper.min.js"></script>
          <script src="../../../assets/js/core/bootstrap.min.js"></script>
          <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/multistep-form.js"></script>
         
          <!-- Kanban scripts -->
          <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
          <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
          <script>
            $(document).ready(function(){
                $.validator.addMethod("checkUserCorreo",function(value, element) {
                  var response = false;
                    $.ajax({
                        type:"POST",
                        async: false,
                        url: "/Register/isUserValidate",
                        data: {email: $("#email").val()},
                        success: function(data) {
                            if(data=="true"){
                                $('#btn_registro_email').attr("disabled", false);
                                $('#confirm_email').attr("disabled", false);
                                $('#email').attr("disabled", true);
                                response = true;
                            }else{
                                $('#btn_registro_email').attr("disabled", true);
                                $('#confirm_email').attr("disabled", true);
                                document.getElementById("confirm_email").value = "";
                            }
                        }
                    });

                    return response;
                },"Usted no está registrado en la Base de Datos CONAVE 2022, verifique con su área y reintente.");

                $("#email_form").validate({
                   rules:{
                        email:{
                            required: true,
                            checkUserCorreo: true
                        },
                        confirm_email:{
                            required: true,
                            equalTo:"#email"
                        }
                    },
                    messages:{
                        email:{
                            required: "Este campo es requerido",
                        },
                        confirm_email:{
                            required: "Este campo es requerido",
                            equalTo: "El Correo Eléctronico no coincide",
                        }
                    }
                });

            });
          
            var uno = document.getElementById("uno"),
                dos = document.getElementById("dos"),
                tres = document.getElementById("tres"),
                cuatro = document.getElementById("cuatro");

            uno.onkeyup = function() {
                if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
                    dos.focus();
                }
            }

            dos.onkeyup = function() {
                if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
                    tres.focus();
                }
            }
            tres.onkeyup = function() {
                if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
                    cuatro.focus();
                }
            }
           
        </script>
      
html;


        $code = $email;
        View::set('header', $extraHeader);
        View::set('footer', $extraFooter);
        View::set('code', $code);
        View::set('alerta', $alerta);
        View::render("codeVerifyPass");
    }

    public function ValidationEmail($email)
    {
        $extraHeader = <<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
        <title>
            Registro Conave
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
        <!--script src="../../../assets/js/plugins/choices.min.js"></script-->

        
        
        

html;
        $extraFooter = <<<html
     
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
       <!--   Core JS Files   -->
          <script src="../../../assets/js/core/popper.min.js"></script>
          <script src="../../../assets/js/core/bootstrap.min.js"></script>
          <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/multistep-form.js"></script>
          <script src="../../../assets/js/plugins/choices.min.js"></script>
          <script type="text/javascript" wfd-invisible="true">
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const example = new Choices(element, {});
            }
            var choicesTags = document.getElementById('choices-tags');
            var color = choicesTags.dataset.color;
            if (choicesTags) {
                const example = new Choices(choicesTags, {
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                addItems: true,
                classNames: {
                    item: 'badge rounded-pill choices-' + color + ' me-2'
                }
                });
            }
        </script>
          <!-- Kanban scripts -->
          <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
          <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
          <script>
            $(document).ready(function(){
                $.validator.addMethod("checkUserCorreo",function(value, element) {
                  var response = false;
                    $.ajax({
                        type:"POST",
                        async: false,
                        url: "/Register/isUserValidate",
                        data: {email: $("#email").val()},
                        success: function(data) {
                            if(data=="true"){
                                $('#btn_registro_email').attr("disabled", false);
                                $('#confirm_email').attr("disabled", false);
                                $('#email').attr("disabled", true);

                                response = true;
                            }else{
                                $('#btn_registro_email').attr("disabled", true);
                                $('#confirm_email').attr("disabled", true);
                                document.getElementById("confirm_email").value = "";
                            }
                        }
                    });

                    return response;
                },"Usted no está registrado en la Base de Datos CONAVE 2022, verifique con su área y reintente.");

                $("#email_form").validate({
                   rules:{
                        email:{
                            required: true,
                            checkUserCorreo: true
                        },
                        confirm_email:{
                            required: true,
                            equalTo:"#email"
                        }
                    },
                    messages:{
                        email:{
                            required: "Este campo es requerido",
                        },
                        confirm_email:{
                            required: "Este campo es requerido",
                            equalTo: "El Correo Eléctronico no coincide",
                        }
                    }
                });

            });
            
          
        </script>
      
html;
        $code = $email;
        View::set('header', $extraHeader);
        View::set('footer', $extraFooter);
        View::set('code', $code);
        View::render("formulario");
    }

    public function Data()
    {
        $extraHeader = <<<html
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
            <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
            <title>
                Registro Conave
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
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <style>
            .select2-container--default .select2-selection--single {
            height: 38px!important;
            border-radius: 8px!important;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #444;
                line-height: 32px;
            }
            .select2-container--default.select2-container--focus .select2-selection--multiple {
               // height: 38px!important;
                border-radius: 8px!important;
            }
            
            // .select2-container--default .select2-selection--multiple {
            //     height: 38px!important;
            //     border-radius: 8px!important;
            // }
            </style>
           
            
            <!--script src="../../../assets/js/plugins/choices.min.js"></script-->
html;
        $extraFooter = <<<html
     
            <script src="/js/jquery.min.js"></script>
            <script src="/js/validate/jquery.validate.js"></script>
            <script src="/js/alertify/alertify.min.js"></script>
            <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
            <script src="../../../assets/js/core/popper.min.js"></script>
            <script src="../../../assets/js/core/bootstrap.min.js"></script>
            <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
            <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
            <!--<script src="../../../assets/js/plugins/multistep-form.js"></script>-->
            <script src="../../../assets/js/plugins/choices.min.js"></script>
            <script type="text/javascript" wfd-invisible="true">
                // if (document.getElementById('choices-button')) {
                //     var element = document.getElementById('choices-button');
                //     const example = new Choices(element, {});
                // }
                // var choicesTags = document.getElementById('choices-tags');
                // var color = choicesTags.dataset.color;
                // if (choicesTags) {
                //     const example = new Choices(choicesTags, {
                //     delimiter: ',',
                //     editItems: true,
                //     maxItemCount: 5,
                //     removeItemButton: true,
                //     addItems: true,
                //     classNames: {
                //         item: 'badge rounded-pill choices-' + color + ' me-2'
                //     }
                //     });
                // }
            </script>
            <!-- Kanban scripts -->
            <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
            <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
           
            <script>
                $(document).ready(function(){
                    $.validator.addMethod("checkUserCorreo",function(value, element) {
                    var response = false;
                        $.ajax({
                            type:"POST",
                            async: false,
                            url: "/Register/isUserValidate",
                            data: {email: $("#email").val()},
                            success: function(data) {
                                if(data=="true"){
                                    $('#btn_registro_email').attr("disabled", false);
                                    $('#confirm_email').attr("disabled", false);
                                    $('#email').attr("disabled", true);
                                    response = true;
                                }else{
                                    $('#btn_registro_email').attr("disabled", true);
                                    $('#confirm_email').attr("disabled", true);
                                    document.getElementById("confirm_email").value = "";
                                }
                            }
                        });

                        return response;
                    },"Usted no está registrado en la Base de Datos CONAVE 2022, verifique con su área y reintente.");

                    $("#email_form").validate({
                    rules:{
                            email:{
                                required: true,
                                checkUserCorreo: true
                            },
                            confirm_email:{
                                required: true,
                                equalTo:"#email"
                            }
                        },
                        messages:{
                            email:{
                                required: "Este campo es requerido",
                            },
                            confirm_email:{
                                required: "Este campo es requerido",
                                equalTo: "El Correo Eléctronico no coincide",
                            }
                        }
                    });
                });
            
            </script>

           
      
html;
        if (strlen((date('y') - 18)) != 1) {
            $fecha_min = '20' . (date('y') - 18) . '-' . date('m') . '-' . date('d');
        } else {
            $fecha_min = '200' . (date('y') - 18) . '-' . date('m') . '-' . date('d');
        }

        $fecha_max = '20' . date('y') . '-' . date('m') . '-' . date('d');


        $email = $_POST['email'];
        $digit1 =  $_POST['uno'];
        $digit2 =  $_POST['dos'];
        $digit3 =  $_POST['tres'];
        $digit4 =  $_POST['cuatro'];
        $code_received  = $digit1 . $digit2 . $digit3 . $digit4;
        $optionsGenero = '';
        $optionsLineaPrincipal = '';
        $optionsBu = '';
        $optionsPosiciones = '';
        $optionsEstados = '';
        $optionsCiudades = '';
        $optionsCP = '';
        $optionsAeropuertos = '';
        $numeroEmpleado = '';

        $userData = RegisterDao::getUserRegister($email)[0];

        if ($userData['genero'] != '') {
            if ($userData['genero'] == "Hombre") {
                $optionsGenero = <<<html
                    <option value="Hombre" selected>Masculino</option>
                    <option value="Mujer">Femenino</option>
html;
            } else if ($userData['genero'] == "Mujer") {
                $optionsGenero = <<<html
                    <option value="Hombre">Masculino</option>
                    <option value="Mujer" selected>Femenino</option>
html;
            } else {
                $optionsGenero = <<<html
                    <option value="Hombre">Masculino</option>
                    <option value="Mujer">Femenino</option>
html;
            }
        } else {
            $optionsGenero = <<<html
                <option value="Hombre">Masculino</option>
                <option value="Mujer">Femenino</option>
html;
        }

        $Ciudades = RegisterDao::getCiudadesAll();

        foreach ($Ciudades as $key => $value) {
            $optionsCiudades .= <<<html
                <option value="{$value['id_ciudades']}">{$value['nombre']}</option>
html;
        }




        $Estados = RegisterDao::getEstadosAll();

        foreach ($Estados as $key => $value) {
            $optionsEstados .= <<<html
                <option value="{$value['id_estado']}">{$value['nombre']}</option>
html;
        }



        if (empty($userData['numero_empleado']) || $userData['numero_empleado'] == '') {
            $numeroEmpleado = <<<html
             <input id="numero_empleado" name="numero_empleado" maxlength="29" pattern="[a-zA-Z0-9]*" class="form-control" type="text" placeholder="" required="required"  value="" style="text-transform:uppercase;" >
html;
        } else {
            $numeroEmpleado = <<<html
            <input id="numero_empleado" name="numero_empleado" maxlength="29" pattern="[a-zA-Z0-9]*" class="form-control" type="text" placeholder="" required="required"  value="{$userData['numero_empleado']}" style="text-transform:uppercase;" readonly>
html;
        }

        $Aeropuertos = RegisterDao::getAeropuertosAll();

        foreach ($Aeropuertos as $key => $value) {
            $optionsAeropuertos .= <<<html
                <option value="{$value['id_aeropuerto']}">{$value['aeropuerto']}</option>
html;
        }
        $lineaGeneral = LineaGeneralDao::getLineaPrincialAll();

        foreach ($lineaGeneral as $key => $value) {
            $optionsLineaPrincipal .= <<<html
                <option value="{$value['id_linea_principal']}">{$value['nombre']}</option>
html;
        }

        $UnidadNegocio = UnidadNegocioDao::getBuAll();

        foreach ($UnidadNegocio as $key => $value) {
            $optionsBu .= <<<html
                <option value="{$value['id_bu']}">{$value['nombre']}</option>
html;
        }

        $Posiciones = PosicionesDao::getPosicionesAll();

        foreach ($Posiciones as $key => $value) {
            $optionsPosiciones .= <<<html
                <option value="{$value['id_posicion']}">{$value['nombre']}</option>
html;
        }



        //         $id = 9;

        //         $Cp = RegisterDao::getCp($id);
        //         foreach ($Cp as $key => $value) {
        //             $optionsCP .=<<<html
        //                 <option value="{$value['id']}">{$value['codigo_postal']} - {$value['colonia']} - {$value['del_mpio']} - {$value['estado']}</option>
        // html;
        //         } 


        if ($userData['code'] === $code_received) {
            //echo "Se verifico codigo correctamente";
            View::set('optionsLineaPrincipal', $optionsLineaPrincipal);
            View::set('userData', $userData);
            View::set('fecha_min', $fecha_min);
            View::set('fecha_max', $fecha_max);
            View::set('optionsGenero', $optionsGenero);
            View::set('optionsBu', $optionsBu);
            View::set('optionsPosiciones', $optionsPosiciones);
            View::set('optionsCiudades', $optionsCiudades);
            View::set('optionsEstados', $optionsEstados);
            View::set('optionsCp', $optionsCP);
            View::set('optionsAeropuertos', $optionsAeropuertos);
            View::set('numeroEmpleado', $numeroEmpleado);
            // View::set('optionActividad',$optionActividad);
            View::set('email', $email);
            View::set('header', $extraHeader);
            View::set('footer', $extraFooter);
            View::render('update_data_register');
        } else {

            $alerta = <<<html
            <div class="alert alert-danger text-white" role="alert" >
                El codigo de verificación no coincide, Intenta nuevamente!
            </div>
html;
            $this->code($email, $alerta);
        }

        // print_r($user_register);

    }

    public function getCodesByState()
    {
        $estado = $_POST['estado'];
        $Cp = RegisterDao::getCp($estado);

        echo json_encode($Cp);
        exit();
    }

    public function SearchConcidenciaCp()
    {
        $codigo = $_POST['codigo'];
        $estado = $_POST['estado'];

        if (isset($codigo) && isset($estado) && !empty($codigo) && !empty($estado)) {
            $Cp = RegisterDao::getCpByCode($codigo, $estado);

            echo json_encode($Cp);
        }
    }

    public function getLineaByBu()
    {
        $bu = $_POST['bu'];

        if (isset($bu)) {
            $Bu = RegisterDao::getLineByBu($bu);

            echo json_encode($Bu);
        }
    }

    public function getposicionByLinea()
    {
        $linea_principal = $_POST['linea_principal'];

        if (isset($linea_principal)) {
            $posiciones = RegisterDao::getposicionByLine($linea_principal);

            echo json_encode($posiciones);
            //var_dump($posiciones);

        }
    }

    public function Politicas()
    {

        $extraHeader = <<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="../../../assets/img/aso_icon.png">
        <title>
            Registro Conave - Politicas
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
        <!--script src="../../../assets/js/plugins/choices.min.js"></script-->
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>  

html;
        $extraFooter = <<<html
     
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
       <!--   Core JS Files   -->
          <script src="../../../assets/js/core/popper.min.js"></script>
          <script src="../../../assets/js/core/bootstrap.min.js"></script>
          <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/multistep-form.js"></script>
          <script src="../../../assets/js/plugins/choices.min.js"></script>
          <script type="text/javascript" wfd-invisible="true">
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const example = new Choices(element, {});
            }
            var choicesTags = document.getElementById('choices-tags');
            var color = choicesTags.dataset.color;
            if (choicesTags) {
                const example = new Choices(choicesTags, {
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                addItems: true,
                classNames: {
                    item: 'badge rounded-pill choices-' + color + ' me-2'
                }
                });
            }
        </script>
          <!-- Kanban scripts -->
          <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
          <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
           

          <script>
            $(document).ready(function(){
                $("#pass_form").validate({
                   rules:{
                        password:{
                            required: true,
                            minlength: 6
                            
                            
                        },
                        confirm_password:{
                            required: true,
                            equalTo:"#password"
                        }
                    },
                    messages:{
                        password:{
                            required: "Este campo es requerido",
                            minlength: "El password debe tener al menos 6 caracteres"
                        },
                        confirm_password:{
                            required: "Este campo es requerido",
                            equalTo: "El password no coincide",
                        }
                    }
                });

                


            });
        </script>
       
html;



        $documento = new \stdClass();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_registro = $_POST['id_registro'];
            $nombre = $_POST['nombre'];
            $numero_empleado = $_POST['numero_empleado'];
            $segundo_nombre = $_POST['segundo_nombre'];
            $apellido_paterno = $_POST['apellido_paterno'];
            $apellido_materno = $_POST['apellido_materno'];
            $genero = $_POST['genero'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $linea_principal = $_POST['linea_principal'];
            $bu = $_POST['bu'];
            $posicion = $_POST['posicion'];
            $actividad = $_POST['actividad'];
            //$talla = $_POST['talla_playera'];
            //$alergias = $_POST['alergias'];
            $residencia = $_POST['residencia'];
            $ciudades = $_POST['ciudades'];
            //   $aeropuerto = $_POST['aeropuerto'];
            $politica = $_POST['terminos'];
            $cp = $_POST['cp'];
            $restricciones_alimenticias = $_POST['restricciones_alimenticias'];
            $alergias = $_POST['alergias'];
            $alergias_ = implode(",", $alergias);
            if (isset($_POST['alergia_otro'])) {
                $alergia_otro = $_POST['alergia_otro'];
            } else {
                $alergia_otro = '';
            }
            $alergia_medicamento = $_POST['confirm_alergia'];

            if (isset($_POST['alergia_medicamento_cual'])) {
                $alergia_medicamento_cual = $_POST['alergia_medicamento_cual'];
            } else {
                $alergia_medicamento_cual = '';
            }

            if (isset($_POST['restricciones_alimenticias_cual'])) {
                $restricciones_alimenticias_cual = $_POST['restricciones_alimenticias_cual'];
            } else {
                $restricciones_alimenticias_cual = '';
            }

            $documento->_nombre = $nombre;
            $documento->_segundo_nombre = $segundo_nombre;
            $documento->_apellido_paterno = $apellido_paterno;
            $documento->_apellido_materno = $apellido_materno;
            $documento->_genero = $genero;
            $documento->_fecha_nacimiento = $fecha_nacimiento;
            $documento->_email = $email;
            $documento->_telefono = $telefono;
            $documento->_linea_principal = $linea_principal;
            $documento->_actividad = $actividad;
            //$documento->_talla = $talla;
            $documento->_numero_empleado = $numero_empleado;
            $documento->_bu = $bu;
            $documento->_posicion = $posicion;
            $documento->_residencia = $residencia;
            $documento->_ciudades = $ciudades;
            //   $documento->_aeropuerto = $aeropuerto;
            $documento->_cp = $cp;
            $documento->_restricciones_alimenticias = $restricciones_alimenticias;
            $documento->_alergias = $alergias_;
            $documento->_alergia_otro = $alergia_otro;
            $documento->_alergia_medicamento = $alergia_medicamento;
            $documento->_alergia_medicamento_cual = $alergia_medicamento_cual;
            $documento->_restricciones_alimenticias_cual = $restricciones_alimenticias_cual;
            $documento->_politica = $politica;



            $id = DataDao::update($documento);

            if ($id) {
                View::set('email', $email);
                View::set('nombre', $nombre);
                View::set('header', $extraHeader);
                View::set('footer', $extraFooter);
                View::render('politicas');
                //echo 'success';
            } else {

                //quitar esta parte

                View::set('email', $email);
                View::set('nombre', $nombre);
                View::set('header', $extraHeader);
                View::set('footer', $extraFooter);
                View::render('politicas');
            }
        } else {
            echo 'fail REQUEST';
        }
    }

    public function DataPassword()
    {
        $extraHeader = <<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
        <title>
            Registro Conave
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
        <!--script src="../../../assets/js/plugins/choices.min.js"></script-->

html;
        $extraFooter = <<<html
     
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
       <!--   Core JS Files   -->
          <script src="../../../assets/js/core/popper.min.js"></script>
          <script src="../../../assets/js/core/bootstrap.min.js"></script>
          <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/multistep-form.js"></script>
          <script src="../../../assets/js/plugins/choices.min.js"></script>
          <script type="text/javascript" wfd-invisible="true">
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const example = new Choices(element, {});
            }
            var choicesTags = document.getElementById('choices-tags');
            var color = choicesTags.dataset.color;
            if (choicesTags) {
                const example = new Choices(choicesTags, {
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                addItems: true,
                classNames: {
                    item: 'badge rounded-pill choices-' + color + ' me-2'
                }
                });
            }
        </script>
          <!-- Kanban scripts -->
          <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
          <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
           

          <script>
            $(document).ready(function(){
                $("#pass_form").validate({
                   rules:{
                        password:{
                            required: true,
                            minlength: 6
                            
                            
                        },
                        confirm_password:{
                            required: true,
                            equalTo:"#password"
                        }
                    },
                    messages:{
                        password:{
                            required: "Este campo es requerido",
                            minlength: "El password debe tener al menos 6 caracteres"
                        },
                        confirm_password:{
                            required: "Este campo es requerido",
                            equalTo: "El password no coincide",
                        }
                    }
                });

            });
        </script>
       
html;
        $documento = new \stdClass();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_registro = $_POST['id_registro'];
            $nombre = $_POST['nombre'];
            $numero_empleado = $_POST['numero_empleado'];
            $segundo_nombre = $_POST['segundo_nombre'];
            $apellido_paterno = $_POST['apellido_paterno'];
            $apellido_materno = $_POST['apellido_materno'];
            $genero = $_POST['genero'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $linea_principal = $_POST['linea_principal'];
            $bu = $_POST['bu'];
            $posicion = $_POST['posicion'];
            $actividad = $_POST['actividad'];
            //$talla = $_POST['talla_playera'];
            $alergias = $_POST['alergias'];
            $residencia = $_POST['residencia'];
            $ciudades = $_POST['ciudades'];
            //   $aeropuerto = $_POST['aeropuerto'];
            $politica = $_POST['terminos'];
            $cp = $_POST['cp'];
            $restricciones_alimenticias = $_POST['restricciones_alimenticias'];
            $alergias = $_POST['alergias'];
            +$alergias_ = implode(",", $alergias);
            if (isset($_POST['alergia_otro'])) {
                $alergia_otro = $_POST['alergia_otro'];
            } else {
                $alergia_otro = '';
            }
            $alergia_medicamento = $_POST['confirm_alergia'];

            if (isset($_POST['alergia_medicamento_cual'])) {
                $alergia_medicamento_cual = $_POST['alergia_medicamento_cual'];
            } else {
                $alergia_medicamento_cual = '';
            }

            if (isset($_POST['restricciones_alimenticias_cual'])) {
                $restricciones_alimenticias_cual = $_POST['restricciones_alimenticias_cual'];
            } else {
                $restricciones_alimenticias_cual = '';
            }

            $documento->_nombre = $nombre;
            $documento->_segundo_nombre = $segundo_nombre;
            $documento->_apellido_paterno = $apellido_paterno;
            $documento->_apellido_materno = $apellido_materno;
            $documento->_genero = $genero;
            $documento->_fecha_nacimiento = $fecha_nacimiento;
            $documento->_email = $email;
            $documento->_telefono = $telefono;
            $documento->_linea_principal = $linea_principal;
            $documento->_actividad = $actividad;
            //$documento->_talla = $talla;
            $documento->_numero_empleado = $numero_empleado;
            $documento->_bu = $bu;
            $documento->_posicion = $posicion;
            $documento->_residencia = $residencia;
            $documento->_ciudades = $ciudades;
            //   $documento->_aeropuerto = $aeropuerto;
            $documento->_cp = $cp;
            $documento->_restricciones_alimenticias = $restricciones_alimenticias;
            $documento->_alergias = $alergias_;
            $documento->_alergia_otro = $alergia_otro;
            $documento->_alergia_medicamento = $alergia_medicamento;
            $documento->_alergia_medicamento_cual = $alergia_medicamento_cual;
            $documento->_restricciones_alimenticias_cual = $restricciones_alimenticias_cual;
            $documento->_politica = $politica;



            $id = DataDao::update($documento);

            if ($id) {
                View::set('email', $email);
                View::set('nombre', $nombre);
                View::set('politica',$politica);
                View::set('header', $extraHeader);
                View::set('footer', $extraFooter);
                View::render('confirm_pass');
                //echo 'success';
            } else {

                //quitar esta parte

                View::set('email', $email);
                View::set('nombre', $nombre);
                View::set('politica',$politica);
                View::set('header', $extraHeader);
                View::set('footer', $extraFooter);
                View::render('confirm_pass');
            }
        } else {
            echo 'fail REQUEST';
        }
    }

    public function Politicas_()
    {
        $extraHeader = <<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
        <title>
            Registro Conave - Politicas
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
        <!--script src="../../../assets/js/plugins/choices.min.js"></script-->

html;
        $extraFooter = <<<html
     
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
       <!--   Core JS Files   -->
          <script src="../../../assets/js/core/popper.min.js"></script>
          <script src="../../../assets/js/core/bootstrap.min.js"></script>
          <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/multistep-form.js"></script>
          <script src="../../../assets/js/plugins/choices.min.js"></script>
          <script type="text/javascript" wfd-invisible="true">
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const example = new Choices(element, {});
            }
            var choicesTags = document.getElementById('choices-tags');
            var color = choicesTags.dataset.color;
            if (choicesTags) {
                const example = new Choices(choicesTags, {
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                addItems: true,
                classNames: {
                    item: 'badge rounded-pill choices-' + color + ' me-2'
                }
                });
            }
        </script>
          <!-- Kanban scripts -->
          <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
          <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
           

          <script>
            $(document).ready(function(){
                $("#pass_form").validate({
                   rules:{
                        password:{
                            required: true,
                            minlength: 6
                            
                            
                        },
                        confirm_password:{
                            required: true,
                            equalTo:"#password"
                        }
                    },
                    messages:{
                        password:{
                            required: "Este campo es requerido",
                            minlength: "El password debe tener al menos 6 caracteres"
                        },
                        confirm_password:{
                            required: "Este campo es requerido",
                            equalTo: "El password no coincide",
                        }
                    }
                });

            });
        </script>
       
html;

        $email = $_POST['email'];
        $btn_politicas = '';
        if (isset($_POST['btn_success'])) {
            $btn_politicas = $_POST['btn_success'];
        } elseif (isset($_POST['btn_danger'])) {
            $btn_politicas = $_POST['btn_danger'];
        }

        View::set('politica', $btn_politicas);
        View::set('email', $email);
        View::set('header', $extraHeader);
        View::set('footer', $extraFooter);
        View::render('politicas_2');
    }

    public function updatePolitica()
    {

        $register = new \stdClass();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $politica = $_POST['politica_value'];

            $register->_email = $email;
            $register->_politica = $politica;

            $id = RegisterDao::updatePolitica($register);

            if ($id) {
                echo 'success';
            } else {
                echo 'fail';
            }
        }
    }


    public function finalize()
    {

        $register = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $password = $_POST['password'];
            $email = $_POST['email'];
            $politica = $_POST['politica'];


            $userData = RegisterDao::getUserRegister($email)[0];


            $id_registro_acceso = $userData['id_registro_acceso'];

            $register->_password = md5($password);
            $register->_email = $email;
            $register->_politica = $politica;
            $register->_id_registro_acceso = $id_registro_acceso;

            $id = DataDao::insert($register);

            if ($id) {

                //RegisterDao::updatePolitica($register);

                $msg = [
                    'email' => $email,
                    'name' =>  $userData['nombre']
                ];

                $mailer = new Mailer();
                $mailer->mailerRegister($msg);

                echo 'success';
            } else {


                echo 'fail';
            }
        }
    }

    public function recuperarPass()
    {
        $extraHeader = <<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
        <title>
            Registro Conave
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
        <!--script src="../../../assets/js/plugins/choices.min.js"></script-->

        
        
        

html;
        $extraFooter = <<<html
     
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
       <!--   Core JS Files   -->
          <script src="../../../assets/js/core/popper.min.js"></script>
          <script src="../../../assets/js/core/bootstrap.min.js"></script>
          <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/multistep-form.js"></script>
          <script src="../../../assets/js/plugins/choices.min.js"></script>
          <script type="text/javascript" wfd-invisible="true">
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const example = new Choices(element, {});
            }
            var choicesTags = document.getElementById('choices-tags');
            var color = choicesTags.dataset.color;
            if (choicesTags) {
                const example = new Choices(choicesTags, {
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                addItems: true,
                classNames: {
                    item: 'badge rounded-pill choices-' + color + ' me-2'
                }
                });
            }
        </script>
          <!-- Kanban scripts -->
          <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
          <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
           

        <script>
            $(document).ready(function(){
                $('#confirm_email').attr("disabled", true);
                $.validator.addMethod("checkUserCorreo",function(value, element) {
                  var response = false;
                    $.ajax({
                        type:"POST",
                        async: false,
                        url: "/Register/isUserValidateRecoveryPassword",
                        data: {email: $("#email").val()},
                        success: function(data) {
                            if(data=="true"){
                                $('#btn_registro_email').attr("disabled", false);
                                $('#confirm_email').attr("disabled", false);
                                $('#email').attr("readonly");

                                response = true;
                            }else{
                                $('#btn_registro_email').attr("disabled", true);
                                $('#confirm_email').attr("disabled", true);
                                document.getElementById("confirm_email").value = "";
                                
                            }
                        }
                    });

                    return response;
                },"<b >Usted no esta registrado en la plataforma.</b>");

                $("#email_form_recovery_pass").validate({
                   rules:{
                        email:{
                            required: true,
                            checkUserCorreo: true
                        },
                        confirm_email:{
                            required: true,
                            equalTo:"#email"
                        }
                    },
                    messages:{
                        email:{
                            required: "Este campo es requerido",
                        },
                        confirm_email:{
                            required: "Este campo es requerido",
                            equalTo: "El Correo Eléctronico no coincide",
                        }
                    }
                });
                

            });
            
        </script>
       
html;
        View::set('header', $extraHeader);
        View::set('footer', $extraFooter);
        View::render("recuperar_password");
    }

    public function verifyCodePass()
    {
        $register = new \stdClass();

        $email = $_POST['email'];

        $register->_email = $email;

        $codigo_rand = $this->generateRandomString();
        $register->_code = $codigo_rand;

        $id = RegisterDao::update($register);
        if ($id >= 1) {
            $msg = [
                'email' => $register->_email,
                'code' =>  $register->_code
            ];

            $mailer = new Mailer();
            $mailer->mailerRecoveryPass($msg);

            $this->codeRecoveryPass($register->_email);
        } else {
            // echo "holaaaaa";
            // exit();
            $this->code500();
            //$this->Success();
            //$this->alerta($id,'error',$method_pay, $name_register);
        }
    }

    public function ChangePass()
    {
        $extraHeader = <<<html
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
            <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
            <title>
                Registro Conave
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
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <style>
            .select2-container--default .select2-selection--single {
            height: 38px!important;
            border-radius: 8px!important;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #444;
                line-height: 32px;
            }
            .select2-container--default.select2-container--focus .select2-selection--multiple {
               // height: 38px!important;
                border-radius: 8px!important;
            }
            
            // .select2-container--default .select2-selection--multiple {
            //     height: 38px!important;
            //     border-radius: 8px!important;
            // }
            </style>
           
            
            <!--script src="../../../assets/js/plugins/choices.min.js"></script-->
html;
        $extraFooter = <<<html
     
            <script src="/js/jquery.min.js"></script>
            <script src="/js/validate/jquery.validate.js"></script>
            <script src="/js/alertify/alertify.min.js"></script>
            <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
            <script src="../../../assets/js/core/popper.min.js"></script>
            <script src="../../../assets/js/core/bootstrap.min.js"></script>
            <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
            <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
            <!--<script src="../../../assets/js/plugins/multistep-form.js"></script>-->
            <script src="../../../assets/js/plugins/choices.min.js"></script>
            <script type="text/javascript" wfd-invisible="true">
                // if (document.getElementById('choices-button')) {
                //     var element = document.getElementById('choices-button');
                //     const example = new Choices(element, {});
                // }
                // var choicesTags = document.getElementById('choices-tags');
                // var color = choicesTags.dataset.color;
                // if (choicesTags) {
                //     const example = new Choices(choicesTags, {
                //     delimiter: ',',
                //     editItems: true,
                //     maxItemCount: 5,
                //     removeItemButton: true,
                //     addItems: true,
                //     classNames: {
                //         item: 'badge rounded-pill choices-' + color + ' me-2'
                //     }
                //     });
                // }
            </script>
            <!-- Kanban scripts -->
            <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
            <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
           
            <script>
                $(document).ready(function(){
                    $("#pass_form").validate({
                        rules:{
                             password:{
                                 required: true,
                                 minlength: 6
                                 
                                 
                             },
                             confirm_password:{
                                 required: true,
                                 equalTo:"#password"
                             }
                         },
                         messages:{
                             password:{
                                 required: "Este campo es requerido",
                                 minlength: "El password debe tener al menos 6 caracteres"
                             },
                             confirm_password:{
                                 required: "Este campo es requerido",
                                 equalTo: "El password no coincide",
                             }
                         }
                     });
                });
            
            </script>

           
      
html;

        $email = $_POST['email'];
        $digit1 =  $_POST['uno'];
        $digit2 =  $_POST['dos'];
        $digit3 =  $_POST['tres'];
        $digit4 =  $_POST['cuatro'];
        $code_received  = $digit1 . $digit2 . $digit3 . $digit4;


        $userData = RegisterDao::getUserRegister($email)[0];



        if ($userData['code'] === $code_received) {
            // echo "Se verifico codigo correctamente";


            View::set('email', $email);
            View::set('header', $extraHeader);
            View::set('footer', $extraFooter);
            View::render('recovery_pass');
        } else {

            $alerta = <<<html
            <div class="alert alert-danger text-white" role="alert" >
                El codigo de verificación no coincide, Intenta nuevamente!
            </div>
html;
            $this->codeRecoveryPass($email, $alerta);
        }
    }

    public function updatePassword()
    {

        $register = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $password = $_POST['password'];
            $email = $_POST['email'];

            $userData = RegisterDao::getUserRegister($email)[0];



            $register->_password = md5($password);
            $register->_email = $email;

            $update = RegisterDao::updatePassword($register);

            if ($update) {
                $msg = [
                    'email' => $email,
                    'name' =>  $userData['nombre']
                ];

                $mailer = new Mailer();
                $mailer->mailerUpdatePass($msg);

                echo 'success';
            } else {
                echo 'fail';
            }
        }
    }

    public function code500()
    {
        View::render("500");
    }

    public function isUserValidate()
    {
        echo (count(RegisterDao::getUserRegister($_POST['email'])) >= 1) ? 'true' : 'false';
    }

    public function isUserValidateUser()
    {
        echo (count(RegisterDao::getUserRegisterTrue($_POST['email'])) >= 1) ? 'true' : 'false';
    }

    public function isUserValidateRecoveryPassword()
    {
        echo (count(RegisterDao::getUserRegisterRecoveryPass($_POST['email'])) >= 1) ? 'true' : 'false';
    }



    function generateRandomString($length = 4)
    {
        return substr(str_shuffle("0123456789"), 0, $length);
    }
}
