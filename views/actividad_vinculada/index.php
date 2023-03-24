<div class="row text-center">
    <div class="col">
        <h1>Actividad Vinculada</h1>
    </div>
</div>
<div class="row justify-content-center">
    <form id="formActividad_vinculada" class="col-lg-4 border rounded bg-light p-3">
        <input type="hidden" name="id" id="id">
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="nombre">Nombre de Actividad Vinculada</label>
                <input type="text" name="desc" id="desc" class="form-control" placeholder="Ingrese tipo de actividad Vinculada" style="text-transform:uppercase">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button id="btnGuardar" type="submit" class="btn btn-primary w-100">Guardar</button>
            </div>
            <div class="col">
                <button id="btnModificar" type="button" class="btn btn-warning w-100">Modificar</button>
            </div>
            <div class="col">
                <a id="btnCancelar" type="button" class="btn btn-warning w-100" href="/medios-comunicacion/actividad_vinculada">Cancelar</a>
            </div>
        </div>
    </form>
</div>
<div class="row" id="divTabla">
    <div class="col-lg-100">
        <table id="Actividad_vinculada" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>NOMBRE</th>
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
<script src="build/js/actividad_vinculada/index.js"></script>