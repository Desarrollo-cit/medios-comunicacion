<?php


setlocale(LC_TIME, "es_ES");
// var_dump(($colores));
$fechaLarga = strftime(" %B ");

 $tipo = $incidencia_mara[0]['tipo'];
//  var_dump(($tipo));
?>
<div class="row justify-content-center">
    <div class=" ms-1 col border border-2 border-dark  pt-3 bg-light rounded">


        <div class=" col-lg-12  justify-content-center">
            <div class="row mb-2 ">
                <div class="justify-content-center d-flex ">
                    <h1> Resumen de las actividades de maras del mes de <?php echo     $fechaLarga; ?>
                        <a type="button" id="buscarresumen"> <img src="<?= asset('./images/iconos/lupa.png') ?>" style="width:40px; height:40px;" alt="maras"></a>
                        <a type="button" id="buscarmaras"> <img src="<?= asset('./images/iconos/reporte.png') ?>" style="width:40px; height:40px;" alt="maras"></a>
                        <a type="button" id="ver_mapa"> <img src="<?= asset('./images/iconos/mapa_calor.png ') ?>" style="width:40px; height:40px;" alt="maras"></a>
                        <a type="button" id="ver_grafica"> <img src="<?= asset('./images/iconos/btn_graficas.png') ?>" style="width:40px; height:40px;" alt="maras"></a>
                    </h1>
                </div>
            </div>
        </div>
        <div id="cuadro_busquedad_resumen" class="row mb-3 " style="display:none">
            <div class="col-lg-12 text-center ">

                <form class=" ms-5  col-lg-11 justify-content-center border border-2 border-dark rounded bg-dark pt-3  " id="formBusqueda_resumen">
                    <div class="row mb-3">
                        <div class="col">
                            <h2 style="color: white;">Ingrese los criterios de busqueda</h2>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-lg-3">
                            <label for="fecha_resumen" style="color: white;">DE</label>
                            <input type="datetime-local" id="fecha_resumen" name="fecha_resumen" class="form-control" required>
                        </div>
                        <div class="col-lg-3">
                            <label for="fecha_resumen2" style="color: white;">HASTA</label>
                            <input type="datetime-local" id="fecha_resumen2" name="fecha_resumen2" class="form-control" required>
                        </div>
                        <div class="col-lg-2 pt-4">
                            <button type="submit" class="btn btn-info w-100"><i class="bi bi-search me-2"></i>Buscar</button>
                        </div>
                    </div>


                </form>

            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-2 text-center">
                <div class="row">
                    <div class="col">
                        <p class="h5">Actividades Vinculadas </p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-2 col-sm-4">
                        <img src="<?= asset('./images/iconos/maras/ladron.png') ?>" class="w-100" alt="capturas">

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="h3" id="cantidadActividad"><?= $maras_actividades[0]['cantidad'] 
                         ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 text-center">
                <div class="row">
                    <div class="col">
                        <p class="h5">Mareros Capturados</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-2 col-sm-4">
                        <img src="<?= asset('./images/iconos/capturas/delito.png') ?>" class="w-100" alt="capturas">

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="h3" id="CantidadMareros"><?= $marerosCapturados[0]['cantidad']  ?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 text-center">
                <div class="row">
                    <div class="col">
                        <p class="h5"> Mara Salvatrucha</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-2 col-sm-4">
                        <img src="<?= asset('./images/iconos/capturas/handcuffs.png') ?>" class="w-100" alt="capturas">

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="h3" id="cantidadSalvatrucha"><?= $capturasSalvatrucha[0]['cantidad'] ?></p>
                    </div>
                </div>
            </div>


            <div class="col-lg-2 text-center">
                <div class="row">
                    <div class="col">
                        <p class="h5"> Mara 18</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-2 col-sm-4">
                        <img src="<?= asset('./images/iconos/capturas/handcuffs.png') ?>" class="w-100" alt="capturas">

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="h3" id="cantidadmara18"><?= $capturas18[0]['cantidad'] ?></p>
                    </div>
                </div>
            </div>


            <div class="col-lg-2 text-center">
                <div class="row">
                    <div class="col">
                        <p class="h5">Departamento con Incidencia </p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-2 col-sm-4">
                        <img src="<?= asset('./images/iconos/ubicacion.png') ?>" class="w-100" alt="capturas">

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p id="depto_mayor" class="h3"><?= $deptoIncidencia[0]['desc'] ?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 text-center">
                <div class="row">
                    <div class="col">
                        <p class="h5">Actividad Incurrente </p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-2 col-sm-4">
                        <img id="img_cambio" src="<?php echo asset("./images/$tipo.png") ?>" class="w-100" alt="capturas">

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p id="incidencia" class="h3"><?= $incidencia_mara[0]['descripcion'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="container-fluid text-center pt-4">
    <div class="justify-content-center">
        <div id="tabla" class="mb-5 ms-5 justify-content-center pt-5" style="border:solid; background-color: #707B7C; display:none;">
            <h1 style="color:aliceblue;">INFORMACIÓN DE LAS ACTIVIDADES VINCULADAS A MARAS</h1>
            <hr style="color: #9A7D0A; height:10px">
            <div class="row col-lg-12 justify-content-center ms-2 mb-3 " style="color:aliceblue;">


                <div class="col-lg-11 table-responsive">

                    <table id='dataTable2' class=' bg-light me-5 table table-hover table-bordered w-100'>
                        <thead class='table-dark text-center'>
                            <tr>
                                <th>NO</th>
                                <th>FECHA</th>
                                <th>MUNICIPIO</th>
                                <th>LUGAR</th>
                                <th>TOPICO</th>
                                <th>ACTIVIDAD VINCULADA</th>
                                <th>DETALLE</th>
                                <th>REPORTE</th>

                            </tr>
                        </thead>
                        <tbody id="tabla_body2" class="text-center bg-light">
                        </tbody>
                    </table>

                </div>
                <br>
                <hr style="color: #9A7D0A; height:10px">
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modaldinero" name="modaldinero" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title " id="infoModalLabel">Informacion de las captura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container">

                <div class="modal-body container ">
                    <form id="formDinero" class="badge-light p-1 was-validated">
                        <!-- <input type="hidden" name="codigo" id="codigo"> -->

                        <div class="row mb-3">
                            <div class='col-lg-6'>
                                <label for="fecha">
                                    Fecha
                                </label>
                                <input type="datetime-local" id="fecha1" name="fech1a" class="form-control" required readonly>

                            </div>
                            <div class='col-lg-6'>
                                <label>
                                    Topico
                                </label>
                                <input type="text" name="topico1" id="topico1" class="form-control" readonly novalidate>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="latitud">Latitud</label>
                                <input type="text" name="latitud1" id="latitud1" class="form-control" readonly novalidate>
                            </div>
                            <div class="col">
                                <label for="longitud">Longitud</label>
                                <input type="text" name="longitud1" id="longitud1" class="form-control" readonly novalidate>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="departamento">Departamento</label>
                                <input type="text" id="departamentoBusqueda1" name="departamentoBusqueda1" class="form-control" required readonly>
                            </div>
                            <div class="col">
                                <label for="municipio">Municipio</label>
                                <input type="text" id="municipio1" name="municipio1" class="form-control" required readonly>
                            </div>
                        </div>

                        <div class="col">
                            <label>Direccion </label>
                            <input type="text" id="lugar1" name="lugar1" class="form-control" required readonly>
                        </div>
                        <div>
                            <label for="actvidad_vinculada"> Actividad vinculada</label>
                            <input type="text" id="actividad_vinculada1" name="actividad_vinculada1" class="form-control" required readonly>
                        </div>



                        <hr>
                        <h1>Detalle de la Incautacion</h1>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="latitud">Cantidad de dinero Incautado</label>
                                <input type="number" name="cantidad_dinero" id="cantidad_dinero" class="form-control" readonly required>
                            </div>
                            <div class="col-lg-3 text-center">
                                <label for="tipo_moneda">Tipo de moneda</label>
                                <input type="text" name="tipo_moneda" id="tipo_moneda" class="form-control" readonly required>

                            </div>
                            <div class="col-lg-3 text-center">
                                <label for="conversion">Converion en quetzales</label>
                                <input type="text" name="conversion" id="conversion" class="form-control" readonly required>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- <button type="submit" form="formIngreso" class="btn btn-primary" id="buttonGuardar">Guardar información</button> -->
            </div>
        </div>
    </div>
</div>

<!-- ____________________________________________________________________________________________________________________________ -->
<!-- ____________________________________________________________________________________________________________________________ -->
<div class="modal fade" id="modaldroga" name="modaldroga" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title " id="infoModalLabel">Informacion de la Incautacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container">

                <div class="modal-body container ">
                    <form id="formdroga" class="badge-light p-1 was-validated">
                        <!-- <input type="hidden" name="codigo" id="codigo"> -->

                        <div class="row mb-3">
                            <div class='col-lg-6'>
                                <label for="fecha">
                                    Fecha
                                </label>
                                <input type="datetime-local" id="fecha1" name="fech1a" class="form-control" required readonly>

                            </div>
                            <div class='col-lg-6'>
                                <label>
                                    Topico
                                </label>

                                <input type="text" name="topico" id="topico" class="form-control" readonly novalidate>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="latitud">Latitud</label>
                                <input type="text" name="latitud" id="latitud" class="form-control" readonly novalidate>
                            </div>
                            <div class="col">
                                <label for="longitud">Longitud</label>
                                <input type="text" name="longitud" id="longitud" class="form-control" readonly novalidate>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="departamentoBusqueda">Departamento</label>
                                <input type="text" id="departamentoBusqueda" name="departamentoBusqueda" class="form-control" required readonly>
                            </div>
                            <div class="col">
                                <label for="municipio">Municipio</label>
                                <input type="text" id="municipio" name="municipio" class="form-control" required readonly>
                            </div>
                        </div>

                        <div class="col">
                            <label>Direccion </label>
                            <input type="text" id="lugar" name="lugar" class="form-control" required readonly>
                        </div>
                        <div>
                            <label for="actvidad_vinculada"> Actividad vinculada</label>
                            <input type="text" id="actvidad_vinculada" name="actvidad_vinculada" class="form-control" required readonly>
                        </div>

                        <hr>
                        <h1>Detalle de la Incautacion</h1>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="latitud">Cantidad incautada en kilos</label>
                                <input type="number" name="cantidad_droga" id="cantidad_droga" class="form-control" readonly required>
                            </div>
                            <div class="col-lg-6 text-center">
                                <label for="tipo_droga">Tipo de droga</label>
                                <input type="text" name="tipo_droga" id="tipo_droga" class="form-control" readonly required>

                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-lg-6 text-center">
                                <label for="transporte">Transporte en que se trasladaba la droga</label>
                                <input type="text" name="transporte" id="transporte" class="form-control" readonly required>

                            </div>
                            <div class="col-lg-3 text-center">
                                <label for="placa">Placa o Matricula</label>
                                <input type="text" name="placa" id="placa" placeholder="P-465FSD" class="form-control" readonly required>
                            </div>
                            <div class="col-lg-3 text-center">
                                <label for="tipo_transporte">Tipo de transporte</label>
                                <input type="text" name="tipo_transporte" id="tipo_transporte" readonly placeholder="JET, BIMOTOR, MONOMOTOR" class="form-control" required>
                            </div>

                        </div>
                        <div class="row mb-3">

                            <div class="col-lg-4 text-center">
                                <label for="matas_incautadas">Matas Incautadas</label>
                                <input type="text" name="matas_incautadas" id="matas_incautadas" class="form-control" readonly required>

                            </div>
                            <div class="col-lg-4 text-center">
                                <label for="tipo_matas">Tipos de Matas</label>
                                <input type="text" name="tipo_matas" id="tipo_matas" class="form-control" readonly required>
                            </div>


                        </div>

                    </form>
                </div>
                <hr>
                <!-- <h1>Personas captuSradas</h1> -->
                <div class="row mb-2 justify-content-center text-center" id="tabla1">
                    <div class="col-sm-12 col-lg-12 table-responsive ">
                        <table id='dataTabledroga' class='table table-hover table-condensed table-bordered w-100'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>NO.</th>
                                    <th>NOMBRE</th>
                                    <th>SEXO</th>
                                    <th>EDAD</th>
                                    <th>NACIONALIDAD</th>
                                    <th>DELITO</th>


                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>






<!-- ____________________________________________________________________________________________________________________________ -->
<div class="modal fade" id="modalArmas" name="modalArmas" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title " id="infoModalLabel">Informacion de las captura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container">

                <div class="modal-body container ">
                    <form id="formArmas" class="badge-light p-1 was-validated">
                        <!-- <input type="hidden" name="codigo" id="codigo"> -->

                        <div class="row mb-3">
                            <div class='col-lg-6'>
                                <label for="fecha">
                                    Fecha
                                </label>
                                <input type="datetime-local" id="fecha" name="fecha" class="form-control" required readonly>

                            </div>
                            <div class='col-lg-6'>
                                <label>
                                    Topico
                                </label>
                                <input type="text" name="topico" id="topico" class="form-control" readonly novalidate>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="latitud">Latitud</label>
                                <input type="text" name="latitud" id="latitud" class="form-control" readonly novalidate>
                            </div>
                            <div class="col">
                                <label for="longitud">Longitud</label>
                                <input type="text" name="longitud" id="longitud" class="form-control" readonly novalidate>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="departamento">Departamento</label>
                                <input type="text" name="departamentoBusqueda" id="departamentoBusqueda" class="form-control" readonly novalidate>
                            </div>
                            <div class="col">
                                <label for="municipio">Municipio</label>
                                <input type="text" id="municipio" name="municipio" class="form-control" required readonly>
                            </div>
                        </div>

                        <div class="col">
                            <label> Direccion </label>
                            <input type="text" id="lugar" name="lugar" class="form-control" required readonly>
                        </div>
                        <div>
                            <label for="actvidad_vinculada"> Actividad vinculada</label>
                            <input type="text" id="actvidad_vinculada" name="actvidad_vinculada" class="form-control" required readonly>
                        </div>

                        <hr>


                    </form>
                </div>
                <hr>
                <!-- <h1>Personas captuSradas</h1> -->
                <h2>Armas incautadas</h2>
                <div class="row mb-2 justify-content-center text-center" id="tabla1">
                    <div class="col-sm-12 col-lg-12 table-responsive ">
                        <table id='dataTableArma' class='table table-hover table-condensed table-bordered w-100'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>NO.</th>
                                    <th>TIPO ARMA</th>
                                    <th>CALIBRE</th>
                                    <th>CANTIDAD INCAUTADA</th>



                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>


                    </div>
                </div>
                <hr>
                <h2>Municion incautada</h2>
                <div class="row mb-2 justify-content-center text-center" id="tabla2">
                    <div class="col-sm-12 col-lg-12 table-responsive ">
                        <table id='dataTableMunicion' class='table table-hover table-condensed table-bordered w-100'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>NO.</th>
                                    <th>CALIBRE</th>
                                    <th>CANTIDAD INCAUTADA</th>



                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>
<!-- ____________________________________________________________________________________________________________________________ -->
<!-- ____________________________________________________________________________________________________________________________ -->
<!-- ____________________________________________________________________________________________________________________________ -->

<div class="modal fade" id="modalcapturas" name="modalcapturas" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title " id="infoModalLabel">Informacion de las captura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container">

                <div class="modal-body container ">
                    <form id="form_captura" class="badge-light p-1 was-validated">
                        <!-- <input type="hidden" name="codigo" id="codigo"> -->

                        <div class="row mb-3">
                            <div class='col-lg-6'>
                                <label for="fecha">
                                    Fecha
                                </label>
                                <input type="datetime-local" id="fecha1" name="fecha1" class="form-control" required readonly>

                            </div>
                            <div class='col-lg-6'>
                                <label>
                                    Topico
                                </label>
                                <input type="text" name="topicoCapturas" id="topicoCapturas" class="form-control" readonly novalidate>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="latitud">Latitud</label>
                                <input type="text" name="latitud" id="latitud" class="form-control" readonly novalidate>
                            </div>
                            <div class="col">
                                <label for="longitud">Longitud</label>
                                <input type="text" name="longitud" id="longitud" class="form-control" readonly novalidate>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="departamento">Departamento</label>
                                <input type="text" name="departamentoCapturas" id="departamentoCapturas" class="form-control" readonly novalidate>
                            </div>
                            <div class="col">
                                <label for="municipio">Municipio</label>
                                <input type="text" id="municipio" name="municipio" class="form-control" required readonly>
                            </div>
                        </div>

                        <div class="col">
                            <label> Direccion </label>
                            <input type="text" id="lugar" name="lugar" class="form-control" required readonly>
                        </div>
                        <div>
                            <label for="actvidad_vinculada"> Actividad vinculada</label>
                            <input type="text" id="actvidad_vinculadaCapturas" name="actvidad_vinculadaCapturas" class="form-control" required readonly>
                        </div>

                    </form>
                </div>
                <hr>
                <h2>Personas capturadas</h2>
                <div class="row mb-2 justify-content-center text-center" id="tabla_captura">
                    <div class="col-sm-12 col-lg-12 table-responsive ">
                        <table id='dataTable_captura' class='table table-hover table-condensed table-bordered w-100'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>NO.</th>
                                    <th>NOMBRE</th>
                                    <th>SEXO</th>
                                    <th>EDAD</th>
                                    <th>NACIONALIDAD</th>
                                    <th>DELITO</th>


                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- <button type="submit" form="formIngreso" class="btn btn-primary" id="buttonGuardar">Guardar información</button> -->
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modalmuerte" name="modalPersonal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title " id="infoModalLabel">Informacion de las muertes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container">

                <div class="modal-body container ">
                    <form id="formMuerte" class="badge-light p-1 was-validated">
                        <!-- <input type="hidden" name="codigo" id="codigo"> -->

                        <div class="row mb-3">
                            <div class='col-lg-6'>
                                <label for="fecha">
                                    Fecha
                                </label>
                                <input type="datetime-local" id="fecha1" name="fecha1" class="form-control" required readonly>

                            </div>
                            <div class='col-lg-6'>
                                <label>
                                    Topico
                                </label>
                                <input type="text" name="topico" id="topico" class="form-control" readonly novalidate>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="latitud">Latitud</label>
                                <input type="text" name="latitud" id="latitud" class="form-control" readonly novalidate>
                            </div>
                            <div class="col">
                                <label for="longitud">Longitud</label>
                                <input type="text" name="longitud" id="longitud" class="form-control" readonly novalidate>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col lg-6">
                                <label for="departamento">Departamento</label>
                                <input type="text" name="departamentobusquedad" id="departamentobusquedad" class="form-control" readonly novalidate>
                            </div>
                            <div class="col lg-6">
                                <label for="municipio">Municipio</label>
                                <input type="text" id="municipio" name="municipio" class="form-control" required readonly>
                            </div>
                        </div>

                        <div class="col">
                            <label>Direccion </label>
                            <input type="text" id="lugar" name="lugar" class="form-control" required readonly>
                        </div>
                        <div>
                            <label for="actvidad_vinculada"> Actividad vinculada</label>
                            <input type="text" id="actvidad_vinculada" name="actvidad_vinculada" class="form-control" required readonly>
                        </div>

                    </form>
                </div>
                <hr>
                <h2>Personas fallecidas</h2>
                <div class="row mb-2 justify-content-center text-center" id="tabla_muerte">
                    <div class="col-sm-12 col-lg-12 table-responsive ">
                        <table id='dataTable_muerte' class='table table-hover table-condensed table-bordered w-100'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>NO.</th>
                                    <th>NOMBRE</th>
                                    <th>SEXO</th>
                                    <th>EDAD</th>
                                    <th>TIPO DE MUERTE</th>



                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- <button type="submit" form="formIngreso" class="btn btn-primary" id="buttonGuardar">Guardar información</button> -->
            </div>
        </div>
    </div>
</div>


<div class="  container-fluid text-center pt-2 rounded bg-secondary" id="mapa_calor">
    <div class="row mb-1 justify-content-center">

        <div class="  col-lg-12 ">
            <h1 class="ms-5" style="color:white;"> DEPARTAMENTOS CON MAS CAPTURAS EN EL MES DE <?= strtoupper($fechaLarga) ?><a type="button" id="buscaravanzada"> <img src="<?= asset('./images/iconos/lupa.png') ?>" style="width:40px; height:40px;" alt="capturas"></a></h1>
            <hr style="width:100%; height:5px; color:#9A7D0A;">
            <div id="mapa_de_calor">


                <div class="row mb-3 ">
                    <div id="cuadro_busquedad_mapa" style="display:none;">
                        <form class=" col-lg-12 border border-2 border-dark bg-dark rounded " id="formBusqueda_mapa">
                            <div class="row mb-3">
                                <div class="col">
                                    <h2 style="color: white;">Ingrese los criterios de busqueda</h2>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <div class="col-lg-3">
                                    <label for="topicos_mapa_calor" style="color: white;">Topicos</label>
                                    <select class="form-control" name="topico_mapa_calor" id="topico_mapa_calor">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($topicos as $ca3) { ?>
                                            <option value="<?= $ca3['id']  ?>"><?= $ca3['desc']  ?></option>
                                        <?php  }  ?>
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <label for="fecha_mapa" style="color: white;">DE</label>
                                    <input type="datetime-local" id="fecha_mapa" name="fecha_mapa" class="form-control">
                                </div>
                                <div class="col-lg-2">
                                    <label for="fecha2" style="color: white;">HASTA</label>
                                    <input type="datetime-local" id="fecha2" name="fecha2" class="form-control">
                                </div>
                                <div class="col-lg-2 pt-4">
                                    <button type="submit" class="btn btn-info w-100"><i class="bi bi-search me-2"></i>Buscar</button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" row pt-1  ">

        <div class="col-lg-7">



            <svg baseprofile="tiny" fill="#7c7c7c" height="100%" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" version="1.2" viewbox="0 0 1000 1056" width="100%" xmlns="http://www.w3.org/2000/svg">


                <g transform="rotate(328)"><text x="-280" y="570" stroke-width="2" stroke="black" fill="black" style="font-size: 25px">HUEHUETENANGO</text></g>
                <g transform="rotate(320)"><text x="-480" y="620" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">SAN MARCOS</text></g>
                <text x="490" y="250" stroke-width="2" stroke="black" fill="black" style="font-size: 40px">PETEN</text>
                <text x="270" y="610" stroke-width="2" stroke="black" fill="black" style="font-size: 22px">QUICHE</text>
                <text x="440" y="590" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">ALTA VERAPAZ</text>
                <text x="380" y="710" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">BAJA VERAPAZ</text>

                <g transform="rotate(40)"><text c x="800" y="350" stroke-width="2" stroke="black" fill="black" style="font-size: 18px">GUATEMALA</text></g>
                <text x="720" y="590" stroke-width="2" stroke="black" fill="black" style="font-size: 25px">IZABAL</text>
                <text x="635" y="730" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">ZACAPA</text>
                <text x="530" y="740" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">EL </text>
                <text x="490" y="760" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">PROGRESO</text>
                <text x="540" y="830" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">JALAPA</text>
                <text x="440" y="930" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">SANTA</text>
                <text x="440" y="960" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">ROSA</text>
                <text x="240" y="980" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">ESCUINTLA</text>
                <text x="360" y="890" stroke-width="2" stroke="black" fill="black" style="font-size: 30px">↓</text>
                <text x="290" y="910" stroke-width="2" stroke="black" fill="black" style="font-size: 15px">SACATEPEQUEZ</text>
                <text x="190" y="700" stroke-width="2" stroke="black" fill="black" style="font-size: 15px">TOTO-</text>
                <text x="170" y="720" stroke-width="2" stroke="black" fill="black" style="font-size: 15px">NICAPAN</text>
                <text x="120" y="770" stroke-width="2" stroke="black" fill="black" style="font-size: 15px">QUETZAL-</text>
                <text x="115" y="790" stroke-width="2" stroke="black" fill="black" style="font-size: 15px">TENANGO</text>
                <text x="210" y="790" stroke-width="2" stroke="black" fill="black" style="font-size: 15px">SOLOLA</text>
                <text x="251" y="825" stroke-width="2" stroke="black" fill="blue" style="font-size: 50px">•</text>
                <text x="260" y="820" stroke-width="2" stroke="black" fill="blue" style="font-size: 50px">•</text>
                <text x="255" y="825" stroke-width="2" stroke="black" fill="blue" style="font-size: 50px">•</text>
                <g transform="rotate(300)"><text x="-600" y="700" stroke-width="2" stroke="black" fill="black" style="font-size: 15px">CHIMALTENANGO</text></g>
                <text x="165" y="860" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">SUCHI-</text>
                <text x="165" y="880" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">TEPEQUEZ</text>
                <g transform="rotate(38)"><text c x="575" y="650" stroke-width="2" stroke="black" fill="black" style="font-size: 17px">RETALHULEU</text></g>
                <text x="644" y="820" stroke-width="2" stroke="black" fill="black" style="font-size: 18px">CHIQUIMULA</text>

                <g transform="rotate(328)"><text x="-20" y="1090" stroke-width="2" stroke="black" fill="black" style="font-size: 20px">JUTIAPA</text></g>

                <a onclick='detalle(1500)' id="Baja_Verapaz">
                    <path d="M564.6 689.2l-6.7 3.7-9.5 6.5-21.2 14.3-39.3 27.4-4 12.6-1.2 4.1-12.6 2.1-8.2-1.5-3.1-3-1.1-3-2-1.7-4 0.8-2 1.5-0.6 1.5-1 1.3-3.3 0.8-2.9 0.3-2.4-0.3-1.8-1.1-1.2-2.4-1.9 0-4 2.3-6.3 2.3-6.2 1.3-3.8-0.6-1.5 0-1.1 0.6-1.1 0.3-1.3-0.5-1.9-2.2-3.7 0.7-8.8-3.2-2.9-6.6-1.1-2.4-1.8-1.7-1.6-1.1-1.7-1.5-4.5-4.6 1.1-5.6 0.2-1.2-22.4-14.1-18.5-24 1.6-27.9 2 1.1 41.2 9.7 29 1.3 8.2-0.7 9.3-12.8 5.8 0.3 5.6 0.1 8.4 0.2 5.8-0.2 5.4 1.7 13.6 9.3 2.7 2.6 0.7 0.2 1-0.1 2.5-1.4 0.9-1 3.1-3.8 1.1-1 1.7-2.5 2-7.9 0.2-1.6 0.8-1.8 0.9-0.9 1-0.8 3.4 0.2 11.9 2.9 27.1 3.8 9.7-0.3 8.1-3.2 2.3-0.6 11.1-0.9 1.7 0.4 1.9 1.1 2.8 2.7 1.1 1.4 0.6 1.2 0.5 1.2-0.2 2.6-2.6 7.5-11 15.8z" id="1500" name="Baja Verapaz" opacity=0.8>
                    </path>
                </a>

                <a onclick='detalle(1300)' id="Huehuetenango">
                    <path d="M231.8 661.8l-6.4-0.4-2.9 0.5-6 2.7-3.8 2.8-10.8 2.5-2.4 0.7-1.3 0.7-0.9 0.9-3.2 4.8-1.5 2.9-0.2 0.7-0.5 6.5-0.2 0.8-2 1-8.4 0.5-4.8-6-0.8-2.3 0.1-2.6-1.9-1.5-16.7-4.3-1.3-3.5-2.4-2.4-2.5-1.7-4.9-4.2-4.6-4.9-4.1-5.8-3.5-6.3-1.2-3.5-0.2-1-3.8 0.1-13.5 3.8-5.3-0.4-8.4-5.3-2.2-1-1.6 0.1-1.7 0.6-4.2 2.6-7.5 4.7-8.1 0.7-3.4 2.2-8.3 9.7-0.7 0.8-12.7-0.6-2.7-2.1-2.5-26.7-0.6-3.8-3.7-1.4-4.3-5.5-1.5-5.3 9.3-16.1 19.5-34 19.6-34 17.1-29.7 12.1-21.1 4.6-7.9 5.6-9.8 2.9-3.8 4-2 45.5-0.1 34.2 0 34.1-0.1 34.2-0.1 32.8 0-30.4 60.8-2.4 4.7-16.2 33.1-0.6 0.8-4.6 4.5 0.3 1.7 0.5 1.1-0.5 0.4-0.9 0.4-2.1 0.2-1 0.2-1 1.4-6.7 4.8-0.9 0.1-1.5 0-1.5 0.3-0.5 0.3-3.1 2.7-2 0.5-0.7-0.1-0.7 0.5-0.6 1-0.4 3.1-0.6 2.5-1.5 2.9-0.8 1.2-0.8 2.4-0.3 6-1.4 2.3-0.5 1.2-0.3 1.5 0.2 2.4 0.4 1.4 1.1 2.3 0.8 1.1 5 6.1 0.6 1.5 0 3.3 0.3 1.5 1 2.4 1.4 2.3 1.6 1.7 4.6 4.4 1 0.2 1.4 0 7.3-0.9 3.1 0.7 6.9 3.2 0.5 4.6-2.1 9.3 0.2 1.4 1.5 3.9 1.2 5.1-3.8 0.9-2.2 0.2-6.1-1.1-2.2 0.1-5.7 1.9-10.7 2-2 1.3-1.1 2.2z" id="1300" opacity=0.7 name="Huehuetenango">
                    </path>
                </a>

                <a onclick='detalle(1700)' id="Peten">
                    <path d="M747.3 496.1l-1.6-1.3-5.8-0.8-22.8 0.4-2.9 2.9-1.6 4.3-0.4 1.8-0.7 1.7-1 0.9-2.9 1.8-7.5 1.8-3 1.4-1.9-0.2-4.2-2.3-5.3 1.1-6.6 3-0.5-0.2-0.6-13.4-0.2-0.6-1-0.5-1.6-0.1-3.4 0.2-2.6 0.7-1.1 0.7-1.4 0.4-0.9 0-15.4-2.1-1.7 0.1-2.9 2.4-1.2 0.6-1.4 0.3-3.3-0.2-1.1-0.4-1.4-0.7-5.2-3.5-3.9-3.4-0.7-0.4-5.9-2.7-1.4-0.3-2.3 1.5-0.7 0.1-2.2-0.2-1.4 0.2-0.9 0.9-1 1.5-1 0.8-1.4 0.4-8.3 0.5-3.9-0.6-1-0.1-1.6 0.3-0.8-0.3-0.9-0.8-1.2-2.3-0.4-1.3-0.6-1.5-3.2-4.4-0.9-1.6-0.7-1-0.6-0.3-1.4 0.2-2.4-0.3-4.3-3-1.1 1.2-0.6 0.2-2.8-0.6-4.2-3.2 0.6-1.8-0.1-0.5-1.2-0.9-0.3-0.6 0.4-1.4 0-0.6-0.9-0.8-1.8-0.8-1 0 0 0.7 0.5 2 0 0.9-0.6 0.5-2 0.4-1.4 0.4-0.6-0.1-0.9-1.1-1.1-0.1-1.4 0.3-0.9-0.2-0.7-0.9-0.2-0.8-0.6-0.8-1.1-0.2-2.8 0.4-1 0.6-0.7 0.7-0.3 0.9-0.4 0.3-1.7-0.2-42.1-13.6-50.6-7.8-6.7 0.7 0.9-1.3 1.7-3.7 0.7-2.1-2.5 1-0.9 0.9-1.8 0-1-4.4 6-5-3.2-3.1 0-1.6 5.5-2.3-1.7-2.6-7.2-4.1-0.9-4.9 1.7-3.5 3.1-2.4 2.9-1.4-3.4-1.3-2.4-2-0.4-2.6 2.8-3.1 1.1 1.1 0.8 0.4 3.2 0.5-1-1.4-1.5-2.9-0.9-1.4 1.1 0.2 0.3-0.4 0.3-1.4 1.5 1.1 2 0.5 1.6-0.6 0-2.7-1.6 0.6-3.6-1.4-2.5-1.8 1.7-1 4.6-1.4 3.7-3.6 1.4-4.1-2-3.4-1.7 0 0 2-1.7 0 0.6-3.7 2.4-1.3 3.3 0.2 3.8 1.1-2.8-4.9-0.4-1.4 0-3.4-0.5-3.8-1.4-0.3-2.2 1-2.8 0.4-1.5-0.7-1.8-1.2-2.6-1.1-7.8-1-0.6-1.5 0.3-2.2-1.3-2.9-1.4-1.4-2.4-1.7-2.8-0.8-5.9 2.9-1.5-2.3-1.2-5.5-2.4 0-6.4 1.9-1.4 0.7-1.4-0.9-3.5-0.7-4-0.1-3.1 0.9 1.3-2.5 2.2-1.9 1.8-1.9-0.2-2.7-2.8-1.8-3.8-0.3-2.2-0.9 2-4-0.8-4.1 1.6-4.4 0.8-3.7-3.4-2.1-0.7 1.8-0.8 0.8-1.3 0.4-2.1 0.4 0-1.6 3.3-6-3.4-9.4-16.8-24.3-3.6-2.9-8.9-4.5-3.6-3 0.8-3.1 0-1.8-3.4-1.9-2.3 2-2.9-0.1-17.1-5.3-4.6-2.7-7.2-7.3-5.1-2.5 4-4.3-0.6-2.1-3.4-0.5-4.3-0.1-0.4 1.1 0.9 2.4 0.2 2.4-2.4 1.1-1.3-0.8-3.1-3.4-1.5-1.1-9.4-3.5-3-2.6-1.1-5.4-1.4-2.7-8.7-10.6-1-2.3-1.3-5-1.3-1.6-2.6-0.5-6 0.7-2.5-1.1-8.8-9.7-2.3-3.6-1-2.6-1.3-4.6-1-1.8-2.3-1.4-5.1-1.3-1-1.6-0.5-4.1-1.4-4.7-2.1-4.1-2.7-2.3-6.8-0.4-6.6 1.1-5.1-0.9-2-6.2-3.8-2-7.7-1.6-5.7-2.7 1-4.1 1.9-0.3 108.8 0.8 0.2-143.1 2-2.3 5.1-1.4 10.7 0 109 0.1 54.5 0.1 54.6 0 54.4 0.1 54.5 0 109.1 0.1 2.4 128.4 0.3 74-4.1 67.2-4.6 72.8-2.1 26.7-3.9 53.4-6.3 59.7-0.5 12.5z" id="1700" opacity=0.8 name="Petén">
                    </path>
                </a>

                <a onclick='detalle(900)' id="Quetzaltenango">
                    <path d="M181.3 689.4l-4.3 1.4-12.7 5-1.1 0.6-0.5 2.1 1.3 7.4 7.1 27.2 1.8 2.4 4.2 3.8-0.1 3-0.5 1.4 0 1.6 0.5 1.7 3.9 4.7 0.7 1 1.7 0.6 4.8-0.6 5.2-0.2 2.2 5 0.7 7.7 2.7 2.5 4.9 8.6-3 10-7.3 10-10.1 6.8-3.9-1.6-3-0.3-1.5 0.5-5.1 3.4-1.5 0.7-1.2 0.4-0.8 0-1.3-0.3-1.5-0.6-2.6-0.7-1.6 0.4-0.8 0.9-1.7 2.8-1.3 1.7-1.8 2.1-1.6 0.3-1.5-0.9-1.4-0.4-1.4 0.8-0.7 1.7-2.3 2.2-2-0.1-1.4-0.5-3.1-0.5-1.2-0.7-0.7-0.7 0.7-4.5 3.5-8.4 0.4-3.2-0.7-1.2-1.5-0.3-1.1 0.2-1.4 0.7-1 0.7-1.9 1.6-3.3 3.7-8.9 4.3-1.7 2.7-2.1 7-1.1 2.5-4.5 6.7-1.1 2.3-0.8 2.3-0.9 3.7-0.6 1.7-0.5 1-2.5 2.9-7.7 11.6-10.3 2.4-7.3 0.6-2.8-0.4-14.5-6.3-1.1-0.3-1.9 0.7-2 1.4-5.9-17.5-2.2-4.4-0.7-0.3-2.1-0.5-14.7-1.6-1.3-0.3-2.1-0.8-0.8-0.8-0.3-0.7 1-1.6 8.5-9.8 6.8-5.5 2.9-1.5 5.3-1 21.8-6.3 15.5 1.7 7 0.4 2.5-0.3 2.1-0.9 2.5-1.5 3.2-5.9 1.7-2.2 3.3-2.4 0.9-0.9 0.6-1 0.2-0.8 6.7-14.2 2.3-4 1.6-9.6 2.3-3.2 0.4-2.4-0.2-1.8 0.7-1.8 2-1.2 1.9-0.8 7.2-7.1 2-2.8 1-2.6 1.6-11-1.1-4.1-4.7-4-2.9-7.1 2.2-7.7 4.8-7 4.5-4.8 8.6-7 1.6-1.7 1.1-4.8 16.7 4.3 1.9 1.5-0.1 2.6 0.8 2.3 4.8 6z" opacity=0.8 id="0900" name="Quezaltenango">
                    </path>
                </a>

                <a onclick='detalle(1100)' id="Retalhuleu">
                    <path d="M183.4 803.1l-7.4 6.7-5.7 6.3-0.6 1-0.8 1.6-0.2 0.7-0.1 2.9 0.3 5.8-9.8 20.1-0.1 1.6 0.2 1.6-2 15 0.2 1.5 0.9 2.7 3.1 5.6 0.1 1.9-1.1 16.6 0.2 3.4-0.4 2.9-2.8 4.2-3.1 9.4-1.1 7.7-0.5 8.4-0.3 1.6-0.3 0.6-7.1 10.5 1.5 10.2 0.2 2.1-25.8-16.1-36.1-26.5-35-31.8-28-20.3 0.4-0.7 1.7-0.5 2.6 0.7 1.2-0.1 1.2-0.6 2.2-1.6 2.3-2 2-0.6 2.5 0.2 2.3 0.5 1.3 0.5 1.5 0.1 1.6-0.5 1-0.7 2.8-3 2.1-1.1 7.4-1.8 2-1.4 1.9-0.7 1.1 0.3 14.5 6.3 2.8 0.4 7.3-0.6 10.3-2.4 7.7-11.6 2.5-2.9 0.5-1 0.6-1.7 0.9-3.7 0.8-2.3 1.1-2.3 4.5-6.7 1.1-2.5 2.1-7 1.7-2.7 8.9-4.3 3.3-3.7 1.9-1.6 1-0.7 1.4-0.7 1.1-0.2 1.5 0.3 0.7 1.2-0.4 3.2-3.5 8.4-0.7 4.5 0.7 0.7 1.2 0.7 3.1 0.5 1.4 0.5 2 0.1 2.3-2.2 0.7-1.7 1.4-0.8 1.4 0.4 1.5 0.9 1.6-0.3 1.8-2.1 1.3-1.7 1.7-2.8 0.8-0.9 1.6-0.4 2.6 0.7 1.5 0.6 1.3 0.3 0.8 0 1.2-0.4 1.5-0.7 5.1-3.4 1.5-0.5 3 0.3 3.9 1.6z" id="1100" opacity=0.8 name="Retalhuleu">
                    </path>
                </a>
                <a onclick='detalle(1200)' id="San_Marcos">
                    <path d="M157.2 672.7l-1.1 4.8-1.6 1.7-8.6 7-4.5 4.8-4.8 7-2.2 7.7 2.9 7.1 4.7 4 1.1 4.1-1.6 11-1 2.6-2 2.8-7.2 7.1-1.9 0.8-2 1.2-0.7 1.8 0.2 1.8-0.4 2.4-2.3 3.2-1.6 9.6-2.3 4-6.7 14.2-0.2 0.8-0.6 1-0.9 0.9-3.3 2.4-1.7 2.2-3.2 5.9-2.5 1.5-2.1 0.9-2.5 0.3-7-0.4-15.5-1.7-21.8 6.3-5.3 1-2.9 1.5-6.8 5.5-8.5 9.8-1 1.6 0.3 0.7 0.8 0.8 2.1 0.8 1.3 0.3 14.7 1.6 2.1 0.5 0.7 0.3 2.2 4.4 5.9 17.5-7.4 1.8-2.1 1.1-2.8 3-1 0.7-1.6 0.5-1.5-0.1-1.3-0.5-2.3-0.5-2.5-0.2-2 0.6-2.3 2-2.2 1.6-1.2 0.6-1.2 0.1-2.6-0.7-1.7 0.5-0.4 0.7-20.8-15.1 5-0.8 4.5-5.4 5.4-15.2 5.3-9.9 1-3.9-0.2-4.9-4.4-12.6-0.2-1.8 0.3-3.8-0.1-2-2.3-6.3-0.6-2.2-0.2-5.4 1.2-3 5.2-6.1 2.8-7.7-0.7-16 0.8-8.4 3-3 3-0.9 3.2-0.3 3.3-1.5 2.5-2.9 5-11.4-32.2-42-1.8-4.2-0.1-4.8 1.6-4.5 24.5-42.4 1.5 5.3 4.3 5.5 3.7 1.4 0.6 3.8 2.5 26.7 2.7 2.1 12.7 0.6 0.7-0.8 8.3-9.7 3.4-2.2 8.1-0.7 7.5-4.7 4.2-2.6 1.7-0.6 1.6-0.1 2.2 1 8.4 5.3 5.3 0.4 13.5-3.8 3.8-0.1 0.2 1 1.2 3.5 3.5 6.3 4.1 5.8 4.6 4.9 4.9 4.2 2.5 1.7 2.4 2.4 1.3 3.5z" opacity=0.8 id="1200" name="San Marcos">
                    </path>
                </a>

                <a onclick='detalle(1600)' id="Alta_Verapaz">
                    <path d="M707.6 507.8l-6.8 9.1-2.6 2-4.7 0.5-1.5 1-1.3 2.3-0.2 0.7-3.1 5.5-0.9 1.3-0.9 0.7-2.6 1.2-4.1 2.9-1.3 0.6-2.6 0.8-1.2 1.2-0.6 1.3-15.6 22.1-13.9 19.8-1.8 4.4 0.6 0.2 1.1 0.6 1.4 1.5 0.9 1.5 5.5 5.9 2 3 2.1 2.4 3.3 3 0.9 1.4 0.3 1-2 3.3-0.8 1.9-0.7 2.8-0.6 1.2-0.7 1.1-1 0.8-4.7 2.3-1.5 1.1-0.4 0.5-2.2 30.2 0 3.8 0.2 0.9 1 2.5 0.6 1.1 1.7 2.3 1.4 2.4 0.2 1.1 0 1.3-0.8 4.3 0 2.5 0.5 1.3 1.1 2.4 4.4 6.4-17.1 4-7.9-0.5-15.8 2.4-2.9-0.6-8.7-3.4-5.7-0.2-2.6 0.4-6.8 3.1-7.3 1.9-4.1 0.3-12.2-1.4 11-15.8 2.6-7.5 0.2-2.6-0.5-1.2-0.6-1.2-1.1-1.4-2.8-2.7-1.9-1.1-1.7-0.4-11.1 0.9-2.3 0.6-8.1 3.2-9.7 0.3-27.1-3.8-11.9-2.9-3.4-0.2-1 0.8-0.9 0.9-0.8 1.8-0.2 1.6-2 7.9-1.7 2.5-1.1 1-3.1 3.8-0.9 1-2.5 1.4-1 0.1-0.7-0.2-2.7-2.6-13.6-9.3-5.4-1.7-5.8 0.2-8.4-0.2-5.6-0.1-5.8-0.3 1.6-2.2 2.4-4.3 2.3-5.9 0.2-5.2-3.9-2.3-39-6-7.8-3.1-5.1-5-1.3-3.6-0.5-4.7 1.1-4 3.3-1.7 9.9-0.9 3-1.7-2-2.7 0-1.7 7-6.3 1.4-0.7 2.6-2.8 1.7-3-1.6-1.5-1.3-2.3-1.7-5.3-2.5-5.4-3.7-2.6 2.1-4.2-0.2-3.7-2.4-3.3-4.8-3.1-0.1-1.2 0.4-0.3 1.6-0.2-2-1.3-2.3-0.4-2.3 0.4-2 1.3-3-1.7-10.5-3-9.2-1.6-1.9-2.5 0.9-2.9 3.4-2.4-1.4-0.8-3.7-2.9 0-1.6 1.2-0.4 1.1-0.9 1.2-0.6-1.6-2.3-2.4-1.3-2.9-0.3-3.2 0.4 1.5-3.7 6.8-8.6 3.3-9.1 1-1.5 6-2.4 2.6-5-1.5-4.4-6.2-0.7 2.4-8.6 1.9-3.7 2.5-1.8 0-1.7-1.3-0.3-0.1-0.7-0.5-0.8-1.7 1.8-2.2-2.5-1-0.9 0-1.9 3.3-0.8 3.9-3.3 2.8-1.2 0.6 0.8 0.8 1.7 1.2 1.1 1.7-1.1 0.9-2.1-0.4-1.4-0.1-1.1 2.2-1.4-1.8-3.6 10.5-5.7 6.4-1.4 3.6 3.6 1.7 0 0.7-2.1 1.2-0.9 1.4 0 1.7 1.1 0 1.9-2.3 1.2-1.2 0.4 0 1.9 4.2-0.2 2.5 1.5 2.2 2.1 3.2 1.8 0.8-0.9 1.6-1.4 1-1.1 0.5 1.6 0.2 0.1 0.9-1.7 1.8 1.7 0.8-0.1 0.9-1.6 1.7 0 2.6 1.2 4.8-3.1 2.9 1.9 1.5 0 0.4-1.3 0.9-1.1 0.4-1.3 3 1.1 2.6-1 1-2.4-1.5-2.8 2.1-2.9 0.5-2.4-1.2-2.1-2.9-1.5 0.1-0.1 6.7-0.7 50.6 7.8 42.1 13.6 1.7 0.2 0.4-0.3 0.3-0.9 0.7-0.7 1-0.6 2.8-0.4 1.1 0.2 0.6 0.8 0.2 0.8 0.7 0.9 0.9 0.2 1.4-0.3 1.1 0.1 0.9 1.1 0.6 0.1 1.4-0.4 2-0.4 0.6-0.5 0-0.9-0.5-2 0-0.7 1 0 1.8 0.8 0.9 0.8 0 0.6-0.4 1.4 0.3 0.6 1.2 0.9 0.1 0.5-0.6 1.8 4.2 3.2 2.8 0.6 0.6-0.2 1.1-1.2 4.3 3 2.4 0.3 1.4-0.2 0.6 0.3 0.7 1 0.9 1.6 3.2 4.4 0.6 1.5 0.4 1.3 1.2 2.3 0.9 0.8 0.8 0.3 1.6-0.3 1 0.1 3.9 0.6 8.3-0.5 1.4-0.4 1-0.8 1-1.5 0.9-0.9 1.4-0.2 2.2 0.2 0.7-0.1 2.3-1.5 1.4 0.3 5.9 2.7 0.7 0.4 3.9 3.4 5.2 3.5 1.4 0.7 1.1 0.4 3.3 0.2 1.4-0.3 1.2-0.6 2.9-2.4 1.7-0.1 15.4 2.1 0.9 0 1.4-0.4 1.1-0.7 2.6-0.7 3.4-0.2 1.6 0.1 1 0.5 0.2 0.6 0.6 13.4 0.5 0.2 6.6-3 5.3-1.1 4.2 2.3 1.9 0.2 3-1.4 7.5-1.8z" opacity=0.8 id="1600" name="Alta Verapaz">
                    </path>
                </a>

                <a onclick='detalle(400)' id="Chimaltenango">
                    <path d="M394.9 754.1l-0.7 4-0.4 1.4-0.8 1.3-1.9 1.5-2.8 1-1.2 0.7-3.8 2.9-1.2 0.6-1 0.1-0.6-0.3-1.4 0-1.6 1.1-1 0.9-1.5 2.5-2.3 7.7-4.5 7-3.9 7.1-0.7 3.2 1.4 7.4 0.8 2.4 0.8 4.6-0.1 2.7-0.7 1.3-1.5 1.8-3.3 7.2-6.2 4.6-11.2 12.5-5.4 10.3-1.3 7.1 0.2 1.8-6.6 5.2-5.2 5-1.7 2.2-0.3 0.6-1.5 3.7-4.7 9.7-1.8 0.8-1.1-1.4-0.1-0.8 0-2.1-0.5-4.1-0.7-1-0.6-0.5-0.6 0.2-1 0.8-1.3 1.4-1.6 0.7-1.8 0.2-1.3-0.6-1.5-1-2.4-2.2-1.3-0.8-1.1-0.4-2.1 0.5-3.3 1.9-2 0.7-2.3 0.2-1.1-0.1-1.1-0.6-0.7-0.6-3.4-2.6 3.5-9.5 0-3.3 0.4-5.8-0.4-2.5-0.9-1.2-1.6-1.7-1.7-1.6 2-20.4 0.1-5.7 0.7-2.4 2-2.8 5.1-12.3-0.5-5.5 0.2-0.9 1.6-5-4-19.2-0.6-1.7 6.6-3.2 1.8-1.5 5.6-15.9 1.6-2.5 0.9-0.8 2.5-1.2 4.2-1.1 4.1-2.6 4.6 0.9 16.1-0.4 2.9-0.7 3.4-0.6 3.9 0 11.8 3.5 12.8 0 4.2 0.6 7.3 2.5 8.9 1.8 3.4 1.3z" opacity=0.8 id="0400" name="Chimaltenango">
                    </path>
                </a>

                <a onclick='detalle(500)' id="Escuintla">
                    <path d="M396.6 865.7l3.2 9.6 3.6 3.2 2.1 0.7 3.2-0.1 1.4 0.4 1 3.4 1.6 13.2-0.2 8.4 0.8 3.1 3 7 1.5 5.6-3.6 3.5-1.5 2.9-0.8 2.8 0.1 1.2 0.3 0.8 1.6 0.6 3.4 0.6 1.6 0.1 2.3-0.2 3.8-1.4 1-0.1 1.1 0.2 2.2 1.1 0.6 0.9 0.2 0.7-3.1 4-4 3.8-1.6 1-0.7 0.3-4.6 0.7-1.6 0.8 0 3.5 0.9 1.7 0.5 0.5 3.5 3.4 0.5 1.1 0.1 0.8-1 1.6-1 0.8-3.3 1.9-1.2 1.2-1.9 3.6-0.7 2.6-1.4 0.7-2.7 0.4-2.8 0.8-1.1 1.1-0.5 1.2 0 31.8 0 2.8-2.7-0.4-17.1-1.7-19.2 1.9-2.9 0.8-28.3 1.8-33.1-0.6-30.2-3.3-37.4-7.4-52.5-23.4-0.3-2.4-0.8-4 0.2-1.2 0.5-1.4 12.1-17.8 2-4.5 1.2-1.9 1.3-1.3 1.5-2.1 0.3-4.1-0.6-10.3-0.9-6-0.1-2.1 0.1-3.1 0.5-1.8 0.3-0.8 2.6-1.6 2 1.4 0.8 1.2 0.7 2 0.3 0.5 0.7 0.2 1-0.2 1.8-1.1 0.8-0.7 0.5-0.8-0.3-1.2-1.2-2.3-0.5-1.3-0.4-2.2-0.2-1.6 0.1-1.6 0.5-2.2 0.9-1.7 0.9-0.9 7-5.2 1.2-0.7 2-0.6 1 0.4 1.1 0.8 1.6 2.5 0.4 1.3 0 1-1.8 2.6-0.4 1.3 0 0.7 0.6 1.3 1.2 1.6 0.3 1.7-0.5 2.1 0 1.5 0.7 1.5 1.1 1.1 2.2 1.1 1.6 0.3 2.5-0.1 2-1.2 4.5-5 2.7 2.6-1.2 6.2 1.5 0.4 29 2.1 1.5-1 2.2-4.3 1.1-1.7 0.4-1 0.2-1.4 0.7-12.3 1.7-4.4 7-14.5 3.4 2.6 0.7 0.6 1.1 0.6 1.1 0.1 2.3-0.2 2-0.7 3.3-1.9 2.1-0.5 1.1 0.4 1.3 0.8 2.4 2.2 1.5 1 1.3 0.6 1.8-0.2 1.6-0.7 1.3-1.4 1-0.8 0.6-0.2 0.6 0.5 0.7 1 0.5 4.1 0 2.1 0.1 0.8 1.1 1.4 1.8-0.8 4.7-9.7 1.5-3.7 0.3-0.6 1.7-2.2 5.2-5 6.6-5.2 7.3 6.3 2 2.2 0.4 1.3 1.9 4 3.1 5.2 1.6 1.8 1.2 0.8 6.5-5.7 2.1-2.4 1.2-2.3 1.1-1.5 1.1-0.8 2.1-1.3 3.6 0 1.5-0.8 1.2-1.9 1.6-0.5 1 0.7 0.4 0.5 2.7 6 15.9-6.4z" opacity=0.8 id="0500" name="Escuintla">
                    </path>
                </a>

                <a onclick='detalle(100)' id="Guatemala">
                    <path d="M458.8 755.4l-3.1 5.5-1.3 1.7 0 1 0.2 1.4 0.8 1.4 1 0.8 0.7 0.2 1.5 0.2 1.6-0.1 3.4-1 5.7-0.4 1.8 0.6 0.4 0.6 1.1 2.3 2.3 6.4 0.9 6.3-0.3 2.1-1.7 2.2-1 1.8-0.3 1.2 0.1 1.1 1.3 2.7 5.2 5.5 2.3 1.8 14.5 5.3 3.3 1.7 1.5 1.3 2.7 3.1 2.7 0.9-2.3 5.8-1.1 1.8-2.6 1.8-8.1 6.7-1.4 6.1-0.1 4-0.7 2.1-0.6 1.2-1 0.8-0.6 2.8-0.4 8-3 1.4-2.1 0-2.1 0.7-1.4 1.5-4.7 4.3-1.6 1-1.1 0.3-0.4-0.5-0.5-1.2-0.4-3.1-1.2-1.4-1.8-0.5-1 0.1-4.3 1.9-10.1 16.2-4.6 11.6 1.3 12-0.3 3.2-1.3 1.5-0.9 0.7-1.3 0.6-1.5 1.1-2.1 2.5-1 0.6-1.5 0.3-2 0.7-4.8 2.3-4.7 4.4-1.9 1.3-7.1 2.6-1.5-5.6-3-7-0.8-3.1 0.2-8.4-1.6-13.2-1-3.4-1.4-0.4-3.2 0.1-2.1-0.7-3.6-3.2-3.2-9.6 2.2-9.6 1.8-20.6 1.3-3.1 2-2.3-0.5-3 1.4-4.7-0.1-1.9-0.4-0.6-5.7-6.6-2.2-7.4-7.5-9.6-2.5-2.4-1.4-0.2-3.1 0.6-2.3-0.1-2.4-0.5-3.2-2-5.8-5.2 4.5-7 2.3-7.7 1.5-2.5 1-0.9 1.6-1.1 1.4 0 0.6 0.3 1-0.1 1.2-0.6 3.8-2.9 1.2-0.7 2.8-1 1.9-1.5 0.8-1.3 0.4-1.4 0.7-4 8.8 3.2 3.7-0.7 1.9 2.2 1.3 0.5 1.1-0.3 1.1-0.6 1.5 0 3.8 0.6 6.2-1.3 6.3-2.3 4-2.3 1.9 0 1.2 2.4 1.8 1.1 2.4 0.3 2.9-0.3 3.3-0.8 1-1.3 0.6-1.5 2-1.5 4-0.8 2 1.7 1.1 3z" opacity=0.8 id="0100" name="Guatemala">
                    </path>
                </a>

                <a onclick='detalle(1000)' id="Suchitepequez">
                    <path d="M281.7 849.9l1.7 1.6 1.6 1.7 0.9 1.2 0.4 2.5-0.4 5.8 0 3.3-3.5 9.5-7 14.5-1.7 4.4-0.7 12.3-0.2 1.4-0.4 1-1.1 1.7-2.2 4.3-1.5 1-29-2.1-1.5-0.4 1.2-6.2-2.7-2.6-4.5 5-2 1.2-2.5 0.1-1.6-0.3-2.2-1.1-1.1-1.1-0.7-1.5 0-1.5 0.5-2.1-0.3-1.7-1.2-1.6-0.6-1.3 0-0.7 0.4-1.3 1.8-2.6 0-1-0.4-1.3-1.6-2.5-1.1-0.8-1-0.4-2 0.6-1.2 0.7-7 5.2-0.9 0.9-0.9 1.7-0.5 2.2-0.1 1.6 0.2 1.6 0.4 2.2 0.5 1.3 1.2 2.3 0.3 1.2-0.5 0.8-0.8 0.7-1.8 1.1-1 0.2-0.7-0.2-0.3-0.5-0.7-2-0.8-1.2-2-1.4-2.6 1.6-0.3 0.8-0.5 1.8-0.1 3.1 0.1 2.1 0.9 6 0.6 10.3-0.3 4.1-1.5 2.1-1.3 1.3-1.2 1.9-2 4.5-12.1 17.8-0.5 1.4-0.2 1.2 0.8 4 0.3 2.4-5.8-2.6-21.2-12.1-5.3-3.3-0.2-2.1-1.5-10.2 7.1-10.5 0.3-0.6 0.3-1.6 0.5-8.4 1.1-7.7 3.1-9.4 2.8-4.2 0.4-2.9-0.2-3.4 1.1-16.6-0.1-1.9-3.1-5.6-0.9-2.7-0.2-1.5 2-15-0.2-1.6 0.1-1.6 9.8-20.1-0.3-5.8 0.1-2.9 0.2-0.7 0.8-1.6 0.6-1 5.7-6.3 7.4-6.7 10.1-6.8 1.2 1.5 0.7 1.2 3.1 8.2 0.4 2.3-1.2 3.6-5.9 11.3 3.7 3.5 11.3 1.6 3.3 0.9 1.2-3.5 0.2-2-0.1-3.2 0-0.7 0.6-1.5 0.7-0.7 2.1-1.3 1.5-0.5 1.9 0.2 3.7 1.7 2.8 3.4 0.2 0.1 5.6-0.4 2.8-0.7 1.7 0.4 2.5 2.8 7.2 6.4 1.2 1.4 0.4 1.1 0.4 2 0.1 2.4-0.7 3.7 0.1 1.5 1.5 0.9 5.5-0.8 6.9-3.6 2.2-0.3 2.6 0 1.4 0.3 2.4 0.9 3.3 2.1 9.7 7.4z" id="1000" opacity=0.8 name="Suchitepéquez">
                    </path>
                </a>

                <a onclick='detalle(300)' id="Sacatepequez">
                    <path d="M396.6 865.7l-15.9 6.4-2.7-6-0.4-0.5-1-0.7-1.6 0.5-1.2 1.9-1.5 0.8-3.6 0-2.1 1.3-1.1 0.8-1.1 1.5-1.2 2.3-2.1 2.4-6.5 5.7-1.2-0.8-1.6-1.8-3.1-5.2-1.9-4-0.4-1.3-2-2.2-7.3-6.3-0.2-1.8 1.3-7.1 5.4-10.3 11.2-12.5 6.2-4.6 3.3-7.2 1.5-1.8 0.7-1.3 0.1-2.7-0.8-4.6-0.8-2.4-1.4-7.4 0.7-3.2 3.9-7.1 5.8 5.2 3.2 2 2.4 0.5 2.3 0.1 3.1-0.6 1.4 0.2 2.5 2.4 7.5 9.6 2.2 7.4 5.7 6.6 0.4 0.6 0.1 1.9-1.4 4.7 0.5 3-2 2.3-1.3 3.1-1.8 20.6-2.2 9.6z" id="0300" opacity=0.8 name="Sacatepéquez">
                    </path>
                </a>

                <a onclick='detalle(700)' id="Solola">
                    <path d="M288.3 774l0.6 1.7 4 19.2-1.6 5-0.2 0.9 0.5 5.5-5.1 12.3-2 2.8-0.7 2.4-0.1 5.7-2 20.4-9.7-7.4-3.3-2.1-2.4-0.9-1.4-0.3-2.6 0-2.2 0.3-6.9 3.6-5.5 0.8-1.5-0.9-0.1-1.5 0.7-3.7-0.1-2.4-0.4-2-0.4-1.1-1.2-1.4-7.2-6.4-2.5-2.8-1.7-0.4-2.8 0.7-5.6 0.4-0.2-0.1-2.8-3.4-3.7-1.7-1.9-0.2-1.5 0.5-2.1 1.3-0.7 0.7-0.6 1.5 0 0.7 0.1 3.2-0.2 2-1.2 3.5-3.3-0.9-11.3-1.6-3.7-3.5 5.9-11.3 1.2-3.6-0.4-2.3-3.1-8.2-0.7-1.2-1.2-1.5 7.3-10 3-10 1-0.9 11.3-9.7 2.2-0.7 2.9-0.5 5.7 0.9 2.3 0.7 1.4 0.6 1.8 0.2 5.1-2.2 3.4 0 1.7 0.3 4 1.4 2.4 0.1 1.3-0.3 2.8-0.8 3.4-3.4 3.3-4.8 4.8-4.8 3 1.4 1.3 3.4 2.3 4.3 1.6 1.1 2.4 0.3 1.4 0.4 2.9 1.1 1.1 0.8 0.5 0.9-0.2 0.6-1.4 2.3-2 2.3-0.6 1.5 0 1.4 0.4 2.8 0.5 1.2 0.7 0.7 1.4 0 1.2-0.5 1-1.6 1-3.5 1.1-0.7 4.1 1.4z" opacity=0.8 id="0700" name="Sololá">
                    </path>
                </a>

                <a onclick='detalle(800)' id="Totonicapan">
                    <path d="M231.8 661.8l-1.2 7.2 0 4.6 1.2 4 3.4 1.7 0.8 1.8 6.9 7.1 1.7 0.7 1.2 5.1 2.4 3.4 0.4 3.6 1.7 0.6 1.5 2.9 0 1.3-0.2 2.6-0.6 1-0.7 0.5-2.6 0.1-1 0.3-1.3 0.5-2 1.6-0.8 1.2-0.6 1.7-0.2 2 0.1 1.5 0.8 1.1 2.6 1.7 4.4 3.4 1.2 2 1.2 4.6 1.7 2.8 4.1 2.9 0.7 1.4 0.1 1.6-1.9 5.9 7.8 6.2-4.8 4.8-3.3 4.8-3.4 3.4-2.8 0.8-1.3 0.3-2.4-0.1-4-1.4-1.7-0.3-3.4 0-5.1 2.2-1.8-0.2-1.4-0.6-2.3-0.7-5.7-0.9-2.9 0.5-2.2 0.7-11.3 9.7-1 0.9-4.9-8.6-2.7-2.5-0.7-7.7-2.2-5-5.2 0.2-4.8 0.6-1.7-0.6-0.7-1-3.9-4.7-0.5-1.7 0-1.6 0.5-1.4 0.1-3-4.2-3.8-1.8-2.4-7.1-27.2-1.3-7.4 0.5-2.1 1.1-0.6 12.7-5 4.3-1.4 8.4-0.5 2-1 0.2-0.8 0.5-6.5 0.2-0.7 1.5-2.9 3.2-4.8 0.9-0.9 1.3-0.7 2.4-0.7 10.8-2.5 3.8-2.8 6-2.7 2.9-0.5 6.4 0.4z" id="0800" opacity=0.8 name="Totonicapán">
                    </path>
                </a>

                <a onclick='detalle(200)' id="El_Progreso">
                    <path d="M599.1 761.2l-3.9-0.3-3.2 0.1-1.4 0.3-1.4 0.6-3.4 3-8.7 10.9-7.2 4-7.5 2.7-8.3 1-5.7 1.8-7.8 14.4-0.9 1-1.2 0.6-1.9-0.7-3.1-1.5-3.7-0.4-8.4 2.8-6.5 2.5-1 0.7-0.4 0.7-0.3 1.7-1 2.7-3.9 2.3-2.2 0.9-2.7-0.9-2.7-3.1-1.5-1.3-3.3-1.7-14.5-5.3-2.3-1.8-5.2-5.5-1.3-2.7-0.1-1.1 0.3-1.2 1-1.8 1.7-2.2 0.3-2.1-0.9-6.3-2.3-6.4-1.1-2.3-0.4-0.6-1.8-0.6-5.7 0.4-3.4 1-1.6 0.1-1.5-0.2-0.7-0.2-1-0.8-0.8-1.4-0.2-1.4 0-1 1.3-1.7 3.1-5.5 3.1 3 8.2 1.5 12.6-2.1 1.2-4.1 4-12.6 39.3-27.4 21.2-14.3 9.5-6.5 6.7-3.7 12.2 1.4 4.1-0.3 7.3-1.9 9.1 13.2 11.1 16.7 0.2 3.5-12 0.2-1.2 0.2-1 0.4 0.3 1 0.6 1.2 10.9 15.1 2 2.8 3 1.6 3.2 0.5 1.3 0.8 0.6 0.8-0.5 5.1-0.5 1.2-1 0.4-1.2 0.2-5.4 0.2-3.1 1.3-5.5 6.4z" id="0200" opacity=0.8 name="El Progreso">
                    </path>
                </a>

                <a onclick='detalle(600)' id="Santa_Rosa">
                    <path d="M545 874.8l-4.4 14.1-3.5 0.4 0.7 4.8-0.2 0.8-0.6 0.3-1.2-0.5-1.2-0.6-2.8-0.1-8.6 1.7-3.8 3.3-8.9 22 3.6 2.6 11.5 3.3 1.4 0.6 1 0.7 1.7 1.8 7.7 6.4 6.1 5.9 1.2 2.6-0.4 5.6 1.1 10.1-0.3 2.3-0.7 2.2-1.3 2.8-4.3 6.2-1.4 1.6-0.6 0.2-3.3 0.6-2.9 0.8-2.2 1.5-1.6 2.9-3.9 7.3-3.8 2.7-1.9 0.2-2.5-1-9.7-2.4-1.3-0.5-4.8-4-6.9-4.1-4.5 1.3-1.5 1.1-0.4 0.9-0.3 1.5 0.2 2.3 0.9 1.8 0.8 1 1.2 1.3 0.4 1.1 1.8 10.5 0.3 0.7 0.9 0.8 1.3 0.6 0.7 1.2 0.9 2 2.4 9 3.2 5.8 0.4 1.3 0.2 1.2-0.1 4.6-2.5 9.8-1.3-0.5-38.5-17.3-24.6-9.3-19.9-4.7-11.6-1.9 0-2.8 0-31.8 0.5-1.2 1.1-1.1 2.8-0.8 2.7-0.4 1.4-0.7 0.7-2.6 1.9-3.6 1.2-1.2 3.3-1.9 1-0.8 1-1.6-0.1-0.8-0.5-1.1-3.5-3.4-0.5-0.5-0.9-1.7 0-3.5 1.6-0.8 4.6-0.7 0.7-0.3 1.6-1 4-3.8 3.1-4-0.2-0.7-0.6-0.9-2.2-1.1-1.1-0.2-1 0.1-3.8 1.4-2.3 0.2-1.6-0.1-3.4-0.6-1.6-0.6-0.3-0.8-0.1-1.2 0.8-2.8 1.5-2.9 3.6-3.5 7.1-2.6 1.9-1.3 4.7-4.4 4.8-2.3 2-0.7 1.5-0.3 1-0.6 2.1-2.5 1.5-1.1 1.3-0.6 0.9-0.7 1.3-1.5 0.3-3.2-1.3-12 4.6-11.6 10.1-16.2 4.3-1.9 1-0.1 1.8 0.5 1.2 1.4 0.4 3.1 0.5 1.2 0.4 0.5 1.1-0.3 1.6-1 4.7-4.3 1.4-1.5 2.1-0.7 2.1 0 3-1.4 3.1 3.3 0.5 0.7 1.5 1 3.4-0.5 30.5-5.8 1.2 6.1 2.3 3.5 8.8 7.3 6.5 5.1z" opacity=0.8 id="0600" name="Santa Rosa">
                    </path>
                </a>

                <a onclick='detalle(1800)' id="Izabal">
                    <path d="M769.4 711.1l-0.8-0.6-1.8-0.8-1.1-0.8-4.8-5.8-0.5-1.5-1.5-7.2-0.3-4 0.1-2.5-0.1-1.6-1.9-8.2 0-1.7 0.2-1 3.2-1.3 1-0.7 0.8-0.9 0.9-1.7 0.3-1.7 0.5-6.5-0.1-1.6-0.2-0.7-1-1.7-1.2-1.3-1.5-1.2-5.8-3.2-2.5-0.6-7.6-0.7-5.7 1.2-3.6 1.8-6.5 4.9-29 11.8-29.4 9.9-3.7 0.8-10.1 1.2-4.4-6.4-1.1-2.4-0.5-1.3 0-2.5 0.8-4.3 0-1.3-0.2-1.1-1.4-2.4-1.7-2.3-0.6-1.1-1-2.5-0.2-0.9 0-3.8 2.2-30.2 0.4-0.5 1.5-1.1 4.7-2.3 1-0.8 0.7-1.1 0.6-1.2 0.7-2.8 0.8-1.9 2-3.3-0.3-1-0.9-1.4-3.3-3-2.1-2.4-2-3-5.5-5.9-0.9-1.5-1.4-1.5-1.1-0.6-0.6-0.2 1.8-4.4 13.9-19.8 15.6-22.1 0.6-1.3 1.2-1.2 2.6-0.8 1.3-0.6 4.1-2.9 2.6-1.2 0.9-0.7 0.9-1.3 3.1-5.5 0.2-0.7 1.3-2.3 1.5-1 4.7-0.5 2.6-2 6.8-9.1 2.9-1.8 1-0.9 0.7-1.7 0.4-1.8 1.6-4.3 2.9-2.9 22.8-0.4 5.8 0.8 1.6 1.3-0.1 3.2 2.1 3.4 0.5-0.8 2.4-1.2 2.9-1 2.2-0.1 4.5-1.9 19 0.9 7.1-1.2 7.9-0.1 22 5.7 9.4-3.7 3.4 1.6 8.4 7.1 8.6-2.1 11 2.4 8.4 5 0.9 5.4 5.7 0.9 25 15.8-3.1 11.7 0.5 1.7 6.7 0 2.7-1 0.8-2.2-0.3-2-0.6-0.2 0-1.1-0.9-0.9-0.8-1.2 0.1-2 1.2-0.4 2.3 0.3 2.2-0.4 1-2.3 1-4.1 2.2-2.8 2.3-2.2 1.4-2.3 0.3-4-1.9-6.1-0.2-4 1.8 0 0 2.7 0 0.8 1.6 0 2.9-1.9 7.3 1.4 3.5-1.4-5.8-5.4-3.1-2.4-4.6-2.1-1.9-2.6-1.7-2.9-1.7-2.2-10.7-6.1-3-3.8 3.6-4.2 3.7 2.2 7.1 3.1 2.8 1.7 7.2 7.7 5.3 3 12.9 10.9 25.6 12.1 8.4 7.6 2.6 1.2 10.9 9.6 8.8 3.8-2.9 1.1-0.8 2.3 0.2 2.8-1.6 3.5-1.6-2-4.2 1.9-3.7 2-3.9 1.5-5.2 0.1-1.4 1.9-7.5 12.9-11.5 11.4-25.1 19.8-43.2 33.7-42.8 33.4-31.4 24.4-8.6 4.1-25.2 8.4-7.6 3.9-1.6 1.3z" opacity=0.8 id="1800" name="Izabal">
                    </path>
                </a>

                <a onclick='detalle(2000)' id="Chiquimula">
                    <path d="M758.9 751.8l-2.3 3.4-6.2 5.3-1.9 3-0.3 4.8 1.2 3.6 2.2 3.3 5 6.1 2.3 3.9 4.7 11.3 2.7 3.5 2.2 2 1.5 2.3 0.5 4.4-0.7 2-2.6 2.9-0.9 1.6 1.1 12.9-0.2 4.5-1.1 4.3-2.9 2.8-2.9 0.2-6.2-2.2-3.1-0.5-4.2 0.5-1.9 1.3-1.2 2-2.2 2.8-7.8 6.7-3.4 3.8-2.5 4.5-2.1 2.1-5.5 1.4-2.5 1.7-1.6 3.4-0.5 4 0.6 8-7.2-5.3-0.3 0.6-1.3 2-0.3-5-2.5 1-5.6 5.9-3.9 0.8-2.8-1.1-2.8-1.5-4-0.5-2.7 1.2-3.3-4-0.5-0.9 0.1-2.3 0.7-2.9 0.8-2.5 0.7-1.6 1.2-3.6 0.2-1.3 0.1-1.2-0.7-1.7-3.5-3.9-1.5-0.5-18.7 0.7-0.9-0.2-0.8-0.6-2.9-4.2-1.2-2.4-1.4-2-2.2-2.4-3.1-1-10-1.2-2.7 0.1-0.8-0.1 0.9-5.4 8.9-24.9-1-3-0.9-2.1-0.3-1.4 0.1-1.5 0.3-1.5 0.5-3.1 0.1-0.9-0.5-2.9-1-2.8-1.3-2-3.2-1-11.7 0.7 5.8-10.7 1.1-4.2-0.8-6.3 0.3-1.3 5.7-5.4 4.2-3.3 2.9 0.4 8.5 4.4 7.9 3.9 3.7 0.8 13.2 0.3 3.8-0.9 15-12.1 4.8-1.4 2 0 5.5 1.7 3.4 2.3 4 0 12.3-4.1 3.8 1.2 1 1.3 1.6 1.1 1.9-0.1 2.9-1 1.6-1.2 1.1-1.3 1.3-2 1-0.9 1.7-1.2 5.4-2.8 1.9-0.5 1.3-0.2 0.7 0.2 0.9 0.8 0.8 1 0.9 1.8 0.7 1.8 1 1.7 0.8 2z" opacity=0.8 id="2000" name="Chiquimula">
                    </path>
                </a>

                <a onclick='detalle(2100)' id="Jalapa">
                    <path d="M599.1 761.2l-1.9 4.2 0.7 1 1.4 2.6 2.3 3.3 4 7.6 2 2.9 1.5 1.7 0.8 0.1 6.6 0 4 0.6 2.8 0.8 11.7-0.7 3.2 1 1.3 2 1 2.8 0.5 2.9-0.1 0.9-0.5 3.1-0.3 1.5-0.1 1.5 0.3 1.4 0.9 2.1 1 3-8.9 24.9-0.9 5.4 0.8 0.1 2.7-0.1 1.9 5.8 0 2.5-0.2 0.8-5.3 3.2-15.5 7.5-0.5-0.2-2.7-2.2-1.7-1.7-0.8-1-0.9-0.8-1.8-0.3-4.8 1.3-4.1 2.8-4.7 3.1-5.1 3.5-2 3.1-1.3 8.8-11.1-8.7-1.4-0.6-1.8-0.3-1.1 0.1-1.7 0.4-1.6 0.7-1.1 1.1-5.9 7.9-15.7 0.2-6.5-5.1-8.8-7.3-2.3-3.5-1.2-6.1-30.5 5.8-3.4 0.5-1.5-1-0.5-0.7-3.1-3.3 0.4-8 0.6-2.8 1-0.8 0.6-1.2 0.7-2.1 0.1-4 1.4-6.1 8.1-6.7 2.6-1.8 1.1-1.8 2.3-5.8 2.2-0.9 3.9-2.3 1-2.7 0.3-1.7 0.4-0.7 1-0.7 6.5-2.5 8.4-2.8 3.7 0.4 3.1 1.5 1.9 0.7 1.2-0.6 0.9-1 7.8-14.4 5.7-1.8 8.3-1 7.5-2.7 7.2-4 8.7-10.9 3.4-3 1.4-0.6 1.4-0.3 3.2-0.1 3.9 0.3z" opacity=0.8 id="2100" name="Jalapa">
                    </path>
                </a>

                <a onclick='detalle(2200)' id="Jutiapa">
                    <path d="M682.8 877.5l-1.7 0.7-6.1 7.4-3.4 2.5-0.7-4.8-2.7-2.7-3.6-0.3-3.6 2.6-1.6 4 1.1 2.9 1.8 2.6 0.7 2.9-1.6 2.6-2.4 1.7-1.5 2.2 1.5 3.6 5.2 0.7 1.7 0.8 1.5 1.3 0.7 1 1.4 2.8 0.3 1.2 0.5 3.9 0.4 1.6 1.1 1.1 3.2 1.6 0.8 1 0 4-1.6 1.6-26.6 6.4-6.5 3-6.3 4.8-5 5.5-10.6 18.8-0.7 2.1 0.3 1.9 1.8 4.2-0.1 1.4-3.6 1.9-3.7-1.4-6.4-5.1-4.5-1.1-3.7 0.2-11 4.2-2.6 1.7-5.3 5.3-23.8 16.8-3.7 3.2-2.1 3.6-1.6 3.7-2.3 3.6-3.1 2.5-6.8 3.6-2.9 3.1-2 3.7-1.3 4-0.6 4.2 0.1 4 5.3 17.2-1.4-0.6-35.2-14.7 2.5-9.8 0.1-4.6-0.2-1.2-0.4-1.3-3.2-5.8-2.4-9-0.9-2-0.7-1.2-1.3-0.6-0.9-0.8-0.3-0.7-1.8-10.5-0.4-1.1-1.2-1.3-0.8-1-0.9-1.8-0.2-2.3 0.3-1.5 0.4-0.9 1.5-1.1 4.5-1.3 6.9 4.1 4.8 4 1.3 0.5 9.7 2.4 2.5 1 1.9-0.2 3.8-2.7 3.9-7.3 1.6-2.9 2.2-1.5 2.9-0.8 3.3-0.6 0.6-0.2 1.4-1.6 4.3-6.2 1.3-2.8 0.7-2.2 0.3-2.3-1.1-10.1 0.4-5.6-1.2-2.6-6.1-5.9-7.7-6.4-1.7-1.8-1-0.7-1.4-0.6-11.5-3.3-3.6-2.6 8.9-22 3.8-3.3 8.6-1.7 2.8 0.1 1.2 0.6 1.2 0.5 0.6-0.3 0.2-0.8-0.7-4.8 3.5-0.4 4.4-14.1 15.7-0.2 5.9-7.9 1.1-1.1 1.6-0.7 1.7-0.4 1.1-0.1 1.8 0.3 1.4 0.6 11.1 8.7 1.3-8.8 2-3.1 5.1-3.5 4.7-3.1 4.1-2.8 4.8-1.3 1.8 0.3 0.9 0.8 0.8 1 1.7 1.7 2.7 2.2 0.5 0.2 15.5-7.5 5.3-3.2 0.2-0.8 0-2.5-1.9-5.8 10 1.2 3.1 1 2.2 2.4 1.4 2 1.2 2.4 2.9 4.2 0.8 0.6 0.9 0.2 18.7-0.7 1.5 0.5 3.5 3.9 0.7 1.7-0.1 1.2-0.2 1.3-1.2 3.6-0.7 1.6-0.8 2.5-0.7 2.9-0.1 2.3 0.5 0.9 3.3 4z" id="2200" name="Jutiapa" opacity=0.8>
                    </path>
                </a>

                <a onclick='detalle(1900)' id="Zacapa">
                    <path d="M769.4 711.1l-3.4 2.9-3 4.6-3.9 11.8 4.8 4.6 0 6.8-3.1 7.2-1.9 2.8-0.8-2-1-1.7-0.7-1.8-0.9-1.8-0.8-1-0.9-0.8-0.7-0.2-1.3 0.2-1.9 0.5-5.4 2.8-1.7 1.2-1 0.9-1.3 2-1.1 1.3-1.6 1.2-2.9 1-1.9 0.1-1.6-1.1-1-1.3-3.8-1.2-12.3 4.1-4 0-3.4-2.3-5.5-1.7-2 0-4.8 1.4-15 12.1-3.8 0.9-13.2-0.3-3.7-0.8-7.9-3.9-8.5-4.4-2.9-0.4-4.2 3.3-5.7 5.4-0.3 1.3 0.8 6.3-1.1 4.2-5.8 10.7-2.8-0.8-4-0.6-6.6 0-0.8-0.1-1.5-1.7-2-2.9-4-7.6-2.3-3.3-1.4-2.6-0.7-1 1.9-4.2 5.5-6.4 3.1-1.3 5.4-0.2 1.2-0.2 1-0.4 0.5-1.2 0.5-5.1-0.6-0.8-1.3-0.8-3.2-0.5-3-1.6-2-2.8-10.9-15.1-0.6-1.2-0.3-1 1-0.4 1.2-0.2 12-0.2-0.2-3.5-11.1-16.7-9.1-13.2 6.8-3.1 2.6-0.4 5.7 0.2 8.7 3.4 2.9 0.6 15.8-2.4 7.9 0.5 17.1-4 10.1-1.2 3.7-0.8 29.4-9.9 29-11.8 6.5-4.9 3.6-1.8 5.7-1.2 7.6 0.7 2.5 0.6 5.8 3.2 1.5 1.2 1.2 1.3 1 1.7 0.2 0.7 0.1 1.6-0.5 6.5-0.3 1.7-0.9 1.7-0.8 0.9-1 0.7-3.2 1.3-0.2 1 0 1.7 1.9 8.2 0.1 1.6-0.1 2.5 0.3 4 1.5 7.2 0.5 1.5 4.8 5.8 1.1 0.8 1.8 0.8 0.8 0.6z" opacity=0.8 id="1900" name="Zacapa">
                    </path>
                </a>


                <a onclick='detalle(1400)' id="quiche">
                    <path d="M433 662l-9.3 12.8-8.2 0.7-29-1.3-41.2-9.7-2-1.1-1.6 27.9 18.5 24 22.4 14.1-0.2 1.2-1.1 5.6 4.5 4.6 1.7 1.5 1.6 1.1 1.8 1.7 1.1 2.4 2.9 6.6-3.4-1.3-8.9-1.8-7.3-2.5-4.2-0.6-12.8 0-11.8-3.5-3.9 0-3.4 0.6-2.9 0.7-16.1 0.4-4.6-0.9-4.1 2.6-4.2 1.1-2.5 1.2-0.9 0.8-1.6 2.5-5.6 15.9-1.8 1.5-6.6 3.2-4.1-1.4-1.1 0.7-1 3.5-1 1.6-1.2 0.5-1.4 0-0.7-0.7-0.5-1.2-0.4-2.8 0-1.4 0.6-1.5 2-2.3 1.4-2.3 0.2-0.6-0.5-0.9-1.1-0.8-2.9-1.1-1.4-0.4-2.4-0.3-1.6-1.1-2.3-4.3-1.3-3.4-3-1.4-7.8-6.2 1.9-5.9-0.1-1.6-0.7-1.4-4.1-2.9-1.7-2.8-1.2-4.6-1.2-2-4.4-3.4-2.6-1.7-0.8-1.1-0.1-1.5 0.2-2 0.6-1.7 0.8-1.2 2-1.6 1.3-0.5 1-0.3 2.6-0.1 0.7-0.5 0.6-1 0.2-2.6 0-1.3-1.5-2.9-1.7-0.6-0.4-3.6-2.4-3.4-1.2-5.1-1.7-0.7-6.9-7.1-0.8-1.8-3.4-1.7-1.2-4 0-4.6 1.2-7.2 1.1-2.2 2-1.3 10.7-2 5.7-1.9 2.2-0.1 6.1 1.1 2.2-0.2 3.8-0.9-1.2-5.1-1.5-3.9-0.2-1.4 2.1-9.3-0.5-4.6-6.9-3.2-3.1-0.7-7.3 0.9-1.4 0-1-0.2-4.6-4.4-1.6-1.7-1.4-2.3-1-2.4-0.3-1.5 0-3.3-0.6-1.5-5-6.1-0.8-1.1-1.1-2.3-0.4-1.4-0.2-2.4 0.3-1.5 0.5-1.2 1.4-2.3 0.3-6 0.8-2.4 0.8-1.2 1.5-2.9 0.6-2.5 0.4-3.1 0.6-1 0.7-0.5 0.7 0.1 2-0.5 3.1-2.7 0.5-0.3 1.5-0.3 1.5 0 0.9-0.1 6.7-4.8 1-1.4 1-0.2 2.1-0.2 0.9-0.4 0.5-0.4-0.5-1.1-0.3-1.7 4.6-4.5 0.6-0.8 16.2-33.1 2.4-4.7 30.4-60.8 35.6 0 34.2-0.1 34.1-0.1 22.3 0 4.8-0.6 4.5-1.6 2.9 1.5 1.2 2.1-0.5 2.4-2.1 2.9 1.5 2.8-1 2.4-2.6 1-3-1.1-0.4 1.3-0.9 1.1-0.4 1.3-1.5 0-2.9-1.9-4.8 3.1-2.6-1.2-1.7 0-0.9 1.6-0.8 0.1-1.8-1.7-0.9 1.7-0.2-0.1-0.5-1.6-1 1.1-1.6 1.4-0.8 0.9-3.2-1.8-2.2-2.1-2.5-1.5-4.2 0.2 0-1.9 1.2-0.4 2.3-1.2 0-1.9-1.7-1.1-1.4 0-1.2 0.9-0.7 2.1-1.7 0-3.6-3.6-6.4 1.4-10.5 5.7 1.8 3.6-2.2 1.4 0.1 1.1 0.4 1.4-0.9 2.1-1.7 1.1-1.2-1.1-0.8-1.7-0.6-0.8-2.8 1.2-3.9 3.3-3.3 0.8 0 1.9 1 0.9 2.2 2.5 1.7-1.8 0.5 0.8 0.1 0.7 1.3 0.3 0 1.7-2.5 1.8-1.9 3.7-2.4 8.6 6.2 0.7 1.5 4.4-2.6 5-6 2.4-1 1.5-3.3 9.1-6.8 8.6-1.5 3.7 3.2-0.4 2.9 0.3 2.4 1.3 1.6 2.3-1.2 0.6-1.1 0.9-1.2 0.4 0 1.6 3.7 2.9 1.4 0.8-3.4 2.4-0.9 2.9 1.9 2.5 9.2 1.6 10.5 3 3 1.7 2-1.3 2.3-0.4 2.3 0.4 2 1.3-1.6 0.2-0.4 0.3 0.1 1.2 4.8 3.1 2.4 3.3 0.2 3.7-2.1 4.2 3.7 2.6 2.5 5.4 1.7 5.3 1.3 2.3 1.6 1.5-1.7 3-2.6 2.8-1.4 0.7-7 6.3 0 1.7 2 2.7-3 1.7-9.9 0.9-3.3 1.7-1.1 4 0.5 4.7 1.3 3.6 5.1 5 7.8 3.1 39 6 3.9 2.3-0.2 5.2-2.3 5.9-2.4 4.3-1.6 2.2z" id="1400" name="Quiché" opacity=0.8>
                    </path>
                </a>
                <circle cx="462.9" cy="951.6" id="0">
                </circle>
                <circle cx="673.6" cy="716.6" id="1">
                </circle>
                <circle cx="855.4" cy="532.1" id="2">
                </circle>
            </svg>

        </div>

        <div class="  col-lg-4 bg-dark rounded  pt-3 h-50">
            <div class="row mb-2 justify-content-between">
                <div class="col-7 ">
                    <label for="">
                        <h3 style="color:white"><?php echo $colores[0]['descripcion']; ?></h3>
                    </label>

                </div>
                <div class="col-2 ">

                    <div class="border w-100 h-100" style="background-color:<?= $colores[0]['color'] ?>"></div>

                </div>
            </div>
            <div class="row mb-2 justify-content-between">
                <div class="col-7">
                    <label for="">
                        <h3 style="color:white"><?php echo $colores[1]['descripcion'] ?></h3>
                    </label>

                </div>
                <div class="col-2">

                    <div class="border w-100 h-100" style="background-color:<?= $colores[1]['color'] ?>"></div>

                </div>
            </div>
            <div class="row mb-2 justify-content-between">
                <div class="col-7 ">
                    <label for="">
                        <h3 style="color:white"><?php echo $colores[2]['descripcion'] ?></h3>
                    </label>

                </div>
                <div class="col-2  justify-content-end ms-2">

                    <div class="border w-100 h-100" style=" background-color:<?= $colores[2]['color'] ?>"></div>

                </div>
            </div>
            <div class="row mb-2 justify-content-between">
                <div class="col-7 ">
                    <label for="">
                        <h3 style="color:white">SIN REGISTROS</h3>
                    </label>

                </div>
                <div class="col-2  justify-content-end ms-2">

                    <div class="border w-100 h-100" style=" background-color:#0F4A13"></div>

                </div>
            </div>

        </div>

    </div>

    <div class="modal fade" id="modaldepto" name="modaldepto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content  justify-content-start">
                <div class="modal-header " style="background-color: black;">

                    <h5 class="modal-title " style=" color:white" id="infoModalLabel">Informacion del departamento</h5>
                    <button type="button" style="background-color:red;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>


                <div class="modal-body  container-fluid text-center pt-4 ">
                    <form id="formdeptoinfo" class="  badge-light p-1 was-validated">
                        <div class="row mb-3">
                            <!-- <input type="hidden" name="codigo" id="codigo"> -->
                            <div class="col-lg-12 ">
                                <h1 id="depto_name" for="depto"></h1>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-8 justify-content-start">
                                <label for="depto">
                                    <h3>Cantidad de capturas del Barrio 18:</h3>
                                </label>
                            </div>
                            <div id="cantidad_capturas_depto" class="col-lg-2 justify-content-start">
                                <h4 name="deptoinfo" id="deptoinfo" style="color:#116189"></h4>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-8 justify-content-start">
                                <label for="depto">
                                    <h3> Cantidad de capturas de la mara salvatrucha:</h3>
                                </label>
                                </div>
                                <div id="cantidad_capturas_depto1" class="col-lg-2 justify-content-start">
                                <h4 name="deptoinfo1" id="deptoinfo1" style="color:#116189"></h4>
                                </div>
                           

                        </div>
                        <div class="row mb-1">
                            <div id="texto_no" style="display:none;">
                                <h3> No se encontraron actividades</h3>
                            </div>
                            <!-- <div class="col-lg-6 ">

                                        <div style="width: 800px; height:800px; ">
                                            <canvas id="depto_cant" width="50" height="50"></canvas>
                                        </div>
                                    </div> -->
                            <div id="grafica_depto1" class="row ">

                                <div class="col-lg-12">
                                    <h2 style="color:black">Actividades</h2>
                                    <canvas id="actividades_cant"></canvas>
                                </div>

                            </div>

                        </div>


                    </form>
                </div>
                <hr>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <!-- <button type="submit" form="formIngreso" class="btn btn-primary" id="buttonGuardar">Guardar información</button> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class=" ms-2 container-fluid text-center pt-4" id="div_graficas" style="display:none; ">
    <div class="justify-content-center">
        <div class="  row col-lg-12 justify-content-end " style="border:solid; border-radius:10px; background-color:white;">
            <h1 style="color:black">ESTADISTICAS DEL MES DE <?= strtoupper($fechaLarga) ?> <a type="button" id="buscarGrafica"> <img src="<?= asset('./images/iconos/lupa.png') ?>" style="width:40px; height:40px;" alt="capturas"></a> </h1>

            
            <div id="cuadro_busquedad_grafica" class="row mb-3 " style="display:none">
            <div class="col-lg-12 text-center ">

                <form class=" ms-5  col-lg-11 justify-content-center border border-2 border-dark rounded bg-dark pt-3  " id="formBusqueda_grafica">
                    <div class="row mb-3">
                        <div class="col">
                            <h2 style="color: white;">Ingrese los criterios de busqueda</h2>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-lg-3">
                            <label for="fecha_grafica" style="color: white;">DE</label>
                            <input type="datetime-local" id="fecha_grafica" name="fecha_grafica" class="form-control" required>
                        </div>
                        <div class="col-lg-3">
                            <label for="fecha_grafica2" style="color: white;">HASTA</label>
                            <input type="datetime-local" id="fecha_grafica2" name="fecha_grafica2" class="form-control" required>
                        </div>
                        <div class="col-lg-2 pt-4">
                            <button type="submit" class="btn btn-info w-100"><i class="bi bi-search me-2"></i>Buscar</button>
                        </div>
                    </div>


                </form>

            </div>
        </div>
            <hr style="color:#0B3254; height:10px;">
            <div class="row mb-1">
                <div class="col-lg-6 ">

                    <div style="width: 800px; height:900px; ">
                        <h2 style="color:black">Activida de Maras</h2>
                        <canvas id="myChart9" width="50" height="50"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 ">

                    <div style="width: 800px; height:900px; ">
                        <h2 style="color:black">Actividad de Maras por departamentos</h2>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>

            </div>
            <hr style="color:#0B3254; height:10px;">
            <div class="row mb-1">



                <div class="col-lg-12 ">

                    <div class="col-lg-12 " style="height:800px;">
                        <h2 style="color:black">Actividades de maras en el mes de <?= strtoupper($fechaLarga) ?></h2>
                        <canvas id="myChart3" height="100"></canvas>
                    </div>
                </div>


            </div>
            <hr style="color:#0B3254; height:10px;">
            <div class="row mb-1">



                <div class="col-lg-12 ">

                    <div class="col-lg-12 " style="height:800px;">
                        <h2 style="color:black">ESTADISTICAS TRIMESTRALES DE BARRIO 18</h2>
                        <canvas id="myChart4" height="100"></canvas>
                    </div>
                </div>


            </div>
            <div class="row mb-1">



                <div class="col-lg-12 ">

                    <div class="col-lg-12 " style="height:800px;">
                        <h2 style="color:black">ESTADISTICAS TRIMESTRALES DE MARA SALVATRUCHA</h2>
                        <canvas id="myChart11" height="100"></canvas>
                    </div>
                </div>


            </div>
            <hr style="color:#0B3254; height:10px;">
            <div class="row mb-1">



                <div class="col-lg-12 ">

                    <div class="col-lg-12 " style="height:800px;">
                        <h2 style="color:black">ESTADISTICAS TRIMESTRALES </h2>
                        <canvas id="myChart5" height="100"></canvas>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script src="../public/build/js/mapas/infoMaras.js"></script>