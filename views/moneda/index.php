<div class="row text-center">
    <div class="col">
        <h1>MONEDAS</h1>
    </div>
</div>
<div class="row justify-content-center">
    <form id="formMoneda" class="col-lg-4 border rounded bg-light p-3">
        <input type="hidden" name="id" id="id">
        <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <label for="nombre">Nombre de la Moneda</label>
                <input type="text" name="desc" id="desc" class="form-control" placeholder="Ingrese una nueva moneda">
            </div>
        </div>
        <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <label for="number">Precio del cambio </label>
                <input type="number" step="any"  min="0" name="cambio" id="cambio" class="form-control" placeholder="Ingrese el valor de la moneda">
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
        <table id="monedaTabla" class="table table-bordered table-hover w-100 ">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>DESCRIPCION</th>
                    <th>CAMBIO</th>
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script src="build/js/moneda/index.js"></script>