<div class="row text-center">
    <div class="col">
        <h1>DESASTRES NATURALES</h1>
    </div>
</div>
<div class="row justify-content-center">
    <form id="formDesastre" class="col-lg-4 border rounded bg-light p-3">
        <input type="hidden" name="id" id="id">
        <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <label for="nombre">Nombre de los Desastre Natural</label>
                <input type="text" name="desc" id="desc" class="form-control" placeholder="Ingrese nuevo Desastre Natural" style="text-transform:uppercase">
            </div>
        </div>

        <div class="row mb-3 mt-2">
            <div class="col">
                <button id="btnGuardar" type="submit" class="btn btn-primary w-100">Guardar</button>
            </div>
            <div class="col">
                <button id="btnModificar" type="button" class="btn btn-warning w-100">Modificar</button>
            </div>
        </div>
    </form>
</div>
<div class="row justify-content-center" id="divTabla">
    <div class="col-lg-10 text-center">
        <table id="desastresTabla" class="table table-bordered table-hover w-100 ">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>DESCRIPCION</th>
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script src="build/js/desastre_natural/index.js"></script>