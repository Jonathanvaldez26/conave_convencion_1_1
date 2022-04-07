<?php echo $header; ?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
     <!-- Navbar -->
     <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-2">
                    <li class="breadcrumb-item text-sm">
                        <a class="opacity-3 text-dark" href="javascript:;">
                            <svg width="12px" height="12px" class="mb-1" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>shop </title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1716.000000, -439.000000)" fill="#252f40" fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(0.000000, 148.000000)">
                                                <path d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                                                <path d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="/Home/">Inicio</a></li>
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;" disabled>Cenas</a></li>
                </ol>
            </nav>

            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group"></div>
                </div>

                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="/Home/" class="nav-link text-body font-weight-bold mx-lg-4 mx-0 px-0">
                            <i class="fa fa-home me-sm-0"></i>
                            <span class="d-sm-inline d-none">Inicio</span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="/Login/cerrarSession" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa fa-power-off me-sm-1"></i>
                            <span class="d-sm-inline d-none">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-3">
                        <h5 class="mb-2">Cenas</h5>
                        <p class="mb-0">Registrate como anfitrion e invita a tus amigos y disfruta de lo que tenemos preparado para ti.</p>
                    </div>
                    <!-- <div class="card-body p-3">
                        <div class="row">
                            <div class="col-lg-2 col-12 text-center">
                                <div class="border-dashed border-1 border-secondary border-radius-md py-3">
                                    <h6 class="text-dark text-gradient mb-0">Nombre Restaurante 1</h6>
                                    <div class="col-12 text-centers">
                                        <img class="w-15" src="../../assets/img/small-logos/asofarma_prueba_covid.png">
                                    </div>
                                    <h4 class="font-weight-bolder"><span class="small"></span><span id="state1" countto="4">21 lugares</span></h4>
                                </div>
                            </div>
                            <div class="col-lg-2 col-12 text-center mt-4 mt-lg-0">
                                <div class="border-dashed border-1 border-secondary border-radius-md py-3">
                                    <h6 class="text-dark text-gradient mb-0">Nombre Restaurante 2</h6>
                                    <div class="col-12 text-centers">
                                        <img class="w-15" src="../../assets/img/small-logos/asofarma_prueba_covid.png">
                                    </div>
                                    <h4 class="font-weight-bolder"><span class="small"></span><span id="state2" countto="2400"> 58 Lugares</span></h4>
                                </div>
                            </div>
                            <div class="col-lg-2 col-12 text-center mt-4 mt-lg-0">
                                <div class="border-dashed border-1 border-secondary border-radius-md py-3">
                                    <h6 class="text-dark text-gradient mb-0">Nombre Restaurante 3</h6>
                                    <div class="col-12 text-centers">
                                        <img class="w-15" src="../../assets/img/small-logos/asofarma_prueba_covid.png">
                                    </div>
                                    <h4 class="font-weight-bolder"><span class="small"></span><span id="state3" countto="48">48 Lugares</span></h4>
                                </div>
                            </div>
                            <div class="col-lg-2 col-12 text-center mt-4 mt-lg-0">
                                <div class="border-dashed border-1 border-secondary border-radius-md py-3">
                                    <h6 class="text-dark text-gradient mb-0">Nombre Restaurante 4</h6>
                                    <div class="col-12 text-centers">
                                        <img class="w-15" src="../../assets/img/small-logos/asofarma_prueba_covid.png">
                                    </div>
                                    <h4 class="font-weight-bolder"><span id="state4" countto="4">4</span><span class="small"> Lugares</span></h4>
                                </div>
                            </div>
                            <div class="col-lg-2 col-12 text-center mt-4 mt-lg-0">
                                <div class="border-dashed border-1 border-secondary border-radius-md py-3">
                                    <h6 class="text-dark text-gradient mb-0">Nombre Restaurante 5</h6>
                                    <div class="col-12 text-centers">
                                        <img class="w-15" src="../../assets/img/small-logos/asofarma_prueba_covid.png">
                                    </div>
                                    <h4 class="font-weight-bolder"><span class="small"></span><span id="state3" countto="48">48 Lugares</span></h4>
                                </div>
                            </div>
                            <div class="col-lg-2 col-12 text-center mt-4 mt-lg-0">
                                <div class="border-dashed border-1 border-secondary border-radius-md py-3">
                                    <h6 class="text-dark text-gradient mb-0">Nombre Restaurante 6</h6>
                                    <div class="col-12 text-centers">
                                        <img class="w-15" src="../../assets/img/small-logos/asofarma_prueba_covid.png">
                                    </div>
                                    <h4 class="font-weight-bolder"><span id="state4" countto="4">4</span><span class="small"> Lugares</span></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-5 col-12">
                                <h6 class="mb-0">Estas Registrado como Anfitrión de Cena</h6>
                                <p class="text-sm">y hoy tienes reservada una cena</p>
                                <div class="border-dashed border-1 border-secondary border-radius-md p-3">
                                    <p class="text-xs mb-2">Reservaste tu lugar como Anfitrion en <span class="font-weight-bolder">Nombre del Restaurante</span></p>
                                    <p class="text-xs mb-3"><span class="font-weight-bolder">el día 11/02/2022 14:00:25</span> a nombre de:</p>
                                    <div class="d-flex align-items-center">
                                        <div class="form-group w-60">
                                            <div class="input-group bg-gray-200">
                                                <input class="form-control form-control-sm" value="EL NOMBRE DEL EQUIPO ASOFARMA" type="text" disabled="" onfocus="focused(this)" onfocusout="defocused(this)">
                                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Tu cena es hoy 11 de Febrero a las 7:00 pm Hora Local, en Nombre del Restaurante" aria-label="Referral code expires in 24 hours"><i class="ni ni-key-25"></i></span>
                                            </div>
                                        </div>
                                        <a href="javascript:;" class="btn btn-sm btn-outline-secondary ms-2 px-3">Cancelar Reservación</a>
                                    </div>
                                    <p class="text-xs mb-1">Puedes Cancelar tu Reservación en todo momento y registrarte a otra cena.</p>
                                    <p class="text-xs mb-0"><a href="javascript:;">Revisa Disponibilidad</a>.</p>
                                </div>
                            </div>
                            <div class="col-lg-7 col-12 mt-4 mt-lg-0">
                                <h6 class="mb-0">¿Como reservo mi lugar?</h6>
                                <p class="text-sm">En tres sencillos pasos.</p>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="card card-plain text-center">
                                            <div class="card-body">
                                                <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md mb-2">
                                                    <i class="fa fa-eye text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                                <p class="text-sm font-weight-bold mb-2">1. Revisa los restaurantes disponibles para ti y elige. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="card card-plain text-center">
                                            <div class="card-body">
                                                <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md mb-2">
                                                    <i class="ni ni-send text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                                <p class="text-sm font-weight-bold mb-2">2. Registrate como anfitrion, invita a tus amigos y reserva. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="card card-plain text-center">
                                            <div class="card-body">
                                                <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md mb-2">
                                                    <i class="ni ni-spaceship text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                                <p class="text-sm font-weight-bold mb-2">3. Asiste al restaurante, muestra tu pase virtual y disfruta.  </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <div class="row mt-4">
                            <h6 class="mb-2">Restaurantes Disponibles</h6>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="card text-center">
                                    <div class="overflow-hidden position-relative border-radius-lg p-3" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/window-desk.jpg')">
                                        <span></span>
                                        <div class="card-body position-relative z-index-1 d-flex flex-column mt-9">
                                            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-4" href="javascript:;">
                                                Quiero Registrarme
                                                <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 mt-4 mt-lg-0">
                                <div class="card text-center">
                                    <div class="overflow-hidden position-relative border-radius-lg p-3" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/window-desk.jpg')">
                                        <span></span>
                                        <div class="card-body position-relative z-index-1 d-flex flex-column mt-9">
                                            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-4" href="javascript:;">
                                                Quiero Registrarme
                                                <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 mt-4 mt-lg-0">
                                <div class="card text-center">
                                    <div class="overflow-hidden position-relative border-radius-lg p-3" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/window-desk.jpg')">
                                        <span></span>
                                        <div class="card-body position-relative z-index-1 d-flex flex-column mt-9">
                                            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-4" href="javascript:;">
                                                Quiero Registrarme
                                                <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 mt-4 mt-lg-0">
                                <div class="card text-center">
                                    <div class="overflow-hidden position-relative border-radius-lg p-3" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/window-desk.jpg')">
                                        <span></span>
                                        <div class="card-body position-relative z-index-1 d-flex flex-column mt-9">
                                            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-4" href="javascript:;">
                                                Quiero Registrarme
                                                <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="card-body">
                        <form class="form-horizontal" id="add_dinner_form" action="" method="POST">
                            <div class="row mx-5">
                                <div class="col-12">
                                    <h4>Anfitrion:</h4>
                                    <h5><?php echo $anfitrion['nombre'].' '.$anfitrion['segundo_nombre'].' '.$anfitrion['apellido_paterno'].' '.$anfitrion['apellido_materno'];?></h5>
                                    <br>
                                    <h4>Restaurante:</h4>
                                    <div class="row">
                                        <div class="col-5">
                                            <select class="form-control" name="restaurante" id="restaurante" required>
                                                <option selected disabled>Selecciona un restaurante</option>
                                                <?php echo $restaurante;?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>

                                    <h4>Fecha</h4>
                                    <div class="row">
                                        <div class="col-5">
                                            <input class="form-control" required type="date" placeholder="5" name="fecha" id="fecha">
                                        </div>
                                    </div>

                                    <br>
                                    <h4>Hora</h4>
                                    <div class="row">
                                        <div class="col-5">
                                            <input class="form-control" required type="time" placeholder="5" name="hora" id="hora">
                                        </div>
                                    </div>
                                    <br>
                                    
                                    <h4>Numero de invitados:</h4>
                                    <div class="row">
                                        <div class="col-5">
                                            <input class="form-control" required type="number" placeholder="5" min="0" max="5" name="cantidad" id="cantidad">
                                        </div>
                                    </div>
                                    <br>

                                    <h4 id="title_invitados" hidden>Invitados<br></h4>
                                    <!-- invitado 1 -->
                                    <div class="row invitados1" id="invitados1" name="invitados1" hidden>
                                        <div class="col-5 ">
                                            <select class="form-control select_2" name="asistente1" id="asistente1"  required>
                                                <option selected disabled>Selecciona un Asistente</option>
                                                <?php echo $asistente;?>
                                            </select>
                                        </div>
                                        <br>
                                    </div>

                                    <br>
                                    <!-- invitado 2 -->
                                    <div class="row invitados2" id="invitados2" name="invitados2" hidden>
                                        <div class="col-5 ">
                                            <select class="form-control select_2" name="asistente2" id="asistente2"  required>
                                                <option selected disabled>Selecciona un Asistente</option>
                                                <?php echo $asistente;?>
                                            </select>
                                        </div>
                                        <br>
                                    </div>

                                    <br>
                                    <!-- invitado 3 -->
                                    <div class="row invitados3" id="invitados3" name="invitados3" hidden>
                                        <div class="col-5 ">
                                            <select class="form-control select_2" name="asistente3" id="asistente3"  required>
                                                <option selected disabled>Selecciona un Asistente</option>
                                                <?php echo $asistente;?>
                                            </select>
                                        </div>
                                        <br>
                                    </div>

                                    <br>
                                    <!-- invitado 4 -->
                                    <div class="row invitados4" id="invitados4" name="invitados4" hidden>
                                        <div class="col-5 ">
                                            <select class="form-control select_2" name="asistente4" id="asistente4"  required>
                                                <option selected disabled>Selecciona un Asistente</option>
                                                <?php echo $asistente;?>
                                            </select>
                                        </div>
                                        <br>
                                    </div>

                                    <br>
                                    <!-- invitado 5 -->
                                    <div class="row invitados5" id="invitados5" name="invitados5" hidden>
                                        <div class="col-5 ">
                                            <select class="form-control select_2" name="asistente5" id="asistente5"  required>
                                                <option selected disabled>Selecciona un Asistente</option>
                                                <?php echo $asistente;?>
                                            </select>
                                        </div>
                                        <br>
                                    </div>

                                    <br>
                                </div>
                            </div>
                            <br>
                            <div class="mx-5">
                                <button class="btn bg-gradient-success" type="submit">Agregar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</main>

<script>
     $(document).ready(function() {
         
        let inv = $('.invitados1').html();
        // $('.select_2').select2();

        $('#cantidad').on("change",function(event) {
            let cant = $('#cantidad').val();
            console.log(cant);

            if (cant == 0) {
                // $('.invitados').append(inv);
                $('.invitados1').prop('hidden',true);
                $('.invitados2').prop('hidden',true);
                $('.invitados3').prop('hidden',true);
                $('.invitados4').prop('hidden',true);
                $('.invitados5').prop('hidden',true);
                $('#title_invitados').prop('hidden',true);
            } else if (cant == 1) {
                // $('.invitados').append(inv);
                $('.invitados1').prop('hidden',false);
                $('.invitados2').prop('hidden',true);
                $('.invitados3').prop('hidden',true);
                $('.invitados4').prop('hidden',true);
                $('.invitados5').prop('hidden',true);
                $('#title_invitados').prop('hidden',false);
            } else if (cant == 2) {
                $('.invitados2').prop('hidden',false);
                $('.invitados3').prop('hidden',true);
                $('.invitados4').prop('hidden',true);
                $('.invitados5').prop('hidden',true);
                $('#title_invitados').prop('hidden',false);
            } else if (cant == 3) {
                $('.invitados3').prop('hidden',false);
                $('.invitados4').prop('hidden',true);
                $('.invitados5').prop('hidden',true);
                $('#title_invitados').prop('hidden',false);
            }else if (cant == 4) {
                $('.invitados4').prop('hidden',false);
                $('.invitados5').prop('hidden',true);
                $('#title_invitados').prop('hidden',false);
            }else if (cant == 5) {
                $('.invitados5').prop('hidden',false);
                $('#title_invitados').prop('hidden',false);
            }
        })

        
        
        $("#add_dinner_form").on("submit", function(event) {
            // event.preventDefault();

            var formData = new FormData(document.getElementById("add_dinner_form"));
            for (var value of formData.values()) {
              // console.log(value);
            }

            $.ajax({
                url: "/Dinners/agregarCena",
                type: "POST",
                data: formData,
                // dataType: 'json',
                beforeSend: function() {
                    console.log("Procesando....");


                },
                success: function(respuesta) {
                    console.log(respuesta.status);
                    if (respuesta.status == 'success') {
                        swal("¡Se agregó la cena correctamente!", "", "success").
                        then((value) => {
                            window.location.reload();
                        });
                    } else {
                        swal("¡No se pudo agregar ninguna cena!", "", "warning").
                        then((value) => {
                           // window.location.replace("/Account/")
                        });
                    }
                },
                error: function(respuesta) {
                    console.log(respuesta.status);
                }

            });
        });

        $(document).on('change', '#file-input', function(e) {
            $("#form_upload_image").submit();
        });

        $("#form_upload_image").on("submit", function(event) {
            event.preventDefault();
            // alert("funciona");

            var formData = new FormData(document.getElementById("form_upload_image"));
            console.log(formData);

            $.ajax({
                url: "/Account/uploadImage",
                type: "POST",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    console.log("Procesando....");


                },
                success: function(respuesta) {
                    console.log(respuesta);
                    if(respuesta.status == "success"){
                        //location.reload();
                        $("#img-user").attr("src","../../../img/users_conave/"+respuesta.img);
                    }
                   
                },
                error: function(respuesta) {
                    console.log(respuesta);
                }

            });
        });
        $('#select_alergico').select2();
        $('#select_alergico').on("change", function() {
            $('#alergia_otro').removeAttr('required');
        
            var valores = $(this).val();
        
            console.log(valores);
            if (valores != null) {
                if (valores.length) {
        
                    console.log(valores.length);
        
                    $.each(valores, function(key, value) {
                        if (value == 'otros') {
                            console.log(value);
                            $(".cont_alergia_otro").css('display', 'block');
                            $("#alergia_otro").attr('required', 'required');
                            $("#alergia_otro").val("");
                        } else {
                            $(".cont_alergia_otro").css('display', 'none');
        
        
                        }
        
                    });
        
                }
            } else {
                $(".cont_alergia_otro").css('display', 'none');
            }
        });
        
        $('input:radio[name="confirm_alergia"]').change(function() {
            if ($("#confirm_alergia_no").is(':checked')) {
                $(".medicamento_cual").css("display", "none");
                $("#alergia_medicamento_cual").val("");
                $('#alergia_medicamento_cual').removeAttr('required');
            }
        
            if ($("#confirm_alergia_si").is(':checked')) {
                $(".medicamento_cual").css("display", "block");
                $("#alergia_medicamento_cual").attr('required', 'required');
            }
        });
        
        $('input:radio[name="restricciones_alimenticias"]').change(function() {
            if ($("#res_ali_5").is(':checked')) {
                $(".restricciones_alimenticias").css("display", "block");
                $("#restricciones_alimenticias_cual").val("");
                $("#restricciones_alimenticias_cual").attr('required', 'required');
            } else {
                $(".restricciones_alimenticias").css("display", "none");
                $('#restricciones_alimenticias_cual').removeAttr('required');
            }
        
        });
       

    });
</script>
