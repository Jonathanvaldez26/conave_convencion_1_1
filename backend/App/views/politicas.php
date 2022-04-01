<?php echo $header;?>
    
<body class="">
    <main class="main-content mt-0 ps">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../../../assets/img/curved-images/Cintillo-04.png');">
            <span class="mask bg-gradient-dark opacity-0"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">¡Bienvenido!</h1>
                        <p class="text-lead text-white">Convención Nacional de Ventas 2022, Creciendo 5in Límites. </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-12 mx-auto">
                        <div class="card z-index-0">
                            <div class="card-header text-center pt-4">
                                <p>Aviso</p>
                                <p class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">
                                    <i class="fa fa-user-circle"></i>
                                </p>
                            </div>
                            <div class="card-body pt-1">
                                <form class="form-horizontal" id="pass_form" action="/Register/DataPassword" method="POST">
                                    <!-- <input type="hidden" id="id_registro" name="id_registro" value="<?=$id_registro?>"> -->
                                    <input type="hidden" id="email" name="email" value="<?=$email?>">

                                    

                                    <div class="text-center">
                                        <span class="text-danger">
                                            <b>Para registrarte es necesario leer completo el aviso del evento.</b>
                                        </span>
                                    </div>
                                    <br>

                                    <div id="terminos" class="card-header pt-4 text-scroll " style="text-align: justify;">
                                        <!-- <p>Aquí van los terminos y condiciones</p> -->
                                        <span>
                                            Estimado (a)<br><br>

                                            Estamos ansiosos de volvernos a ver … <br><br>

                                            ¡¡Este encuentro será doblemente especial¡¡ <br><br>
                                            Queremos tener la cercanía de una reunión que nos permita seguir fortaleciendo nuestros lazos, porque juntos somos imparables;  guardando siempre para prevenir cualquier tipo de riesgo de contagio los cuidados pertinentes con base en nuestra nueva realidad.<br><br>

                                            Para ello, estamos considerando las medidas que tienen como principal objetivo preservar la seguridad y salud de quienes participaremos en este encuentro, y que como empresa responsable buscamos.<br><br>

                                            Así que además de contar con tu participación activa, confiamos en que seguirás las recomendaciones que se han establecido y comunicado previamente, privilegiando en todo momento tu seguridad y la de todos.<br><br>

                                            Con tu aceptación te comprometes a:<br><br>
                                            <ul>
                                                <li>Proporcionar información fidedigna</li>
                                                <li>Apegarte a las recomendaciones antes, durante y después de la reunión.</li>
                                            </ul>
                                        </span>
                                    </div>
                                    <br>

                                    <div class="row justify-content-center">
                                        <div class="col-md-4 col-sm-12">
                                            <button class="btn btn-sm btn-success w-100 h-100" id="btn_success" disabled name="btn_success" value="1" type="submit">
                                                Acepto y me comprometo
                                            </button>
                                        </div>
                                        <!-- <div class="col-md-4 col-sm-12">
                                            <button class="btn btn-sm btn-danger w-100 h-100" id="btn_danger" disabled name="btn_danger" value="0" type="button">
                                                No acepto  
                                            </button>
                                        </div> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <br>
    </main>

    </body>

<?php echo $footer; ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    
    $(document).ready(function(){
        $('#terminos').scroll(function() {
            if ($('#terminos').scrollTop()+352 > $('#terminos span').height()) {
                document.getElementById('btn_success').removeAttribute('disabled');
                document.getElementById('btn_danger').removeAttribute('disabled');
            }
        });
       // console.log('aaaa');

        $("#btn_danger").on("click",function(event){
            event.preventDefault();
            var politica_value = $(this).val();
            var email = $("#email").val();
            // alert($(this).val());
            // alert($("#email").val());

            $.ajax({
                    url:"/Register/updatePolitica",
                    type: "POST",
                    data: {email,politica_value},
                    beforeSend: function(){
                        console.log("Procesando....");
                    },
                    success: function(respuesta){

                        console.log(respuesta);
                       
                        if(respuesta == 'success'){
                            swal("¡Usted no acepto los terminos!", "", "error").
                            then((value) => {
                                window.location.replace("/Login");
                            });
                        }
                        // else{
                        //     swal("Hubo un error al registrarte!", "", "error").
                        //     then((value) => {
                        //         window.location.replace("/Login")
                        //     });
                        // }

                    },
                    error:function (respuesta)
                    {
                        
                        console.log(respuesta);
                    }

                });
            
        });
    });

    // $(document).ready(function(){
        
        
    //     $("#pass_form").on("submit",function(event){
    //             event.preventDefault();
                
    //                 var formData = new FormData(document.getElementById("pass_form"));
    //                 console.log(formData);
    //                 $.ajax({
    //                 url:"/Register/finalize",
    //                 type: "POST",
    //                 data: formData,
    //                 cache: false,
    //                 contentType: false,
    //                 processData: false,
    //                 beforeSend: function(){
    //                     console.log("Procesando....");

                    
    //                 },
    //                 success: function(respuesta){

    //                     console.log(respuesta);
                       
    //                     if(respuesta == 'success'){
    //                         swal("Te has registrado exitosamente!", "", "success").
    //                         then((value) => {
    //                             window.location.replace("/Login");
    //                         });
    //                     }else{
    //                         swal("Hubo un error al registrarte!", "", "error").
    //                         then((value) => {
    //                             window.location.replace("/Login")
    //                         });
    //                     }

    //                 },
    //                 error:function (respuesta)
    //                 {
                        
    //                     console.log(respuesta);
    //                 }

    //             });
    //         });
    // });
</script>