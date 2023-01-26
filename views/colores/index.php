<div class="modal" tabindex="-1" id="modalColores">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificar Color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnCerrar"></button>
            </div>
            <div class="modal-body">

                <div class="row text-center">
                    <div class="col">
                        <h1>TIPOS DE COLORES</h1>
                    </div>
                </div>
                <div class="row justify-content-center mb-3">
                    <form id="formColores" class="col-lg-11 border rounded bg-light p-3">
                        <input type="hidden" name="id" id="id">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="marca">Descripcion del color</label>
                                <input type="text" name="descripcion" id="descripcion" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="modelo">Cantidad de Inicio de Color</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Color</label>
                            <input type="color" class="form-control" name="color" id="color">

                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="modelo">Nivel</label>
                                <input type="number" name="nivel" id="nivel" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="topico">Topico</label>
                                <select name="nombre_topico" id="nombre_topico" class="form-control" disabled>
                                    <option value="0">Seleccionar</option>
                                    <?php
                                    foreach ($busqueda as $fila) : ?>

                                        <option value="<?= $fila['id'] ?>"> <?= $fila['desc'] ?></option>

                                    <?php endforeach ?>


                                </select>

                            </div>
                        </div>
                        <input type="hidden" id="topico" name="topico">
                        <div class="row mb-3">
                            <div class="col">
                                <button id="btnGuardar" type="submit" class="btn btn-primary w-100">Guardar Color</button>
                            </div>
                            <div class="col">
                                <button id="btnModificar" type="button" class="btn btn-warning w-100">Modificar Color</button>
                            </div>
                        </div>

                </div>
            </div>

        </div>
    </div>
</div>




<div class="row text-center">
    <div class="col">
        <h3>BUSQUEDA DE COLORES POR TOPICO</h3>
    </div>
</div>









<div class="row justify-content-center mb-3">
    <div class="col-lg-4 col-lg-4 border rounded bg-light p-3">
        <label for="topico2">Topico</label>
        <select name="topico2" id="topico2" class="form-control">
            <option value="0">Seleccionar</option>
            <?php
            foreach ($busqueda as $fila) : ?>

                <option value="<?= $fila['id'] ?>"> <?= $fila['desc'] ?> </option>

            <?php endforeach ?>


        </select>






    </div>
</div>




<div class="row justify-content-center" id="divTabla">
    <div class="col-lg-10">
        <table id="coloresTabla" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>DESCRIPCION</th>
                    <th>CANTIDAD DE CORTE</th>
                    <th>COLOR</th>
                    <th>NIVEL</th>
                    <th>TOPICO</th>
                    <th>MODIFICAR</th>

                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script src="build/js/colores/index.js"></script>