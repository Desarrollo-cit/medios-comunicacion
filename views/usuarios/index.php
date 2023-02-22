<div class="row text-center">
    <div class="col">
        <h1>Ingreso usuarios</h1>
    </div>
</div>
<div class="row justify-content-center">
    <form id="formUsuario" class="col-lg-4 border rounded bg-light p-3">
    <input type="hidden" name="id" id="id">
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="nombre">Nombre</label>
                <input type="text" name="desc" id="desc" class="form-control" placeholder="Ingrese nombre" style="text-transform:uppercase">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button id="btnGuardar" type="submit" class="btn btn-primary w-100">Guardar Usuario</button>
            </div>
            <div class="col">
                <button id="btnModificar" type="button" class="btn btn-warning w-100">Modificar</button>
            </div>
            <div class="col">
                <button id="btnSituacion" type="button" class="btn btn-warning w-100">Situación</button>
            </div>
            <!-- <div class="col">
                <button id="btnCancelar" class="btn btn-warning w-100" href="/medios-comunicacion/usuarios">Cancelar</button>
            </div> 
             -->
        </div>
    </form>
</div>
<div class="row justify-content-center" id="divTabla">
    <div class="col-lg-10">
        <table id="usuariosTabla" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>NOMBRE</th>
                    <!-- <th>SITUACION</th> -->
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="build/js/usuarios/index.js"></script>