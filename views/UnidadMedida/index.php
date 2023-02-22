    <div class="row text-center">
    <div class="col">
        <h1>Medidas</h1>
    </div>
</div>
<div class="row justify-content-center">
    <form id="formMedidas" class="col-lg-4 border rounded bg-light p-3">
        <input type="hidden" name="id" id="id">
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="nombre">Nombre de la medida</label>
                <input type="text" name="desc" id="desc" class="form-control" placeholder="Ingrese nombre de la medida" style="text-transform:uppercase">
            </div>
            </div>
            <div class="row mb-3">
                    <div class="col-lg-3 d-grid mb-lg-0 mb-2">
                        <button type="submit" class="btn btn-success" id="btnGuardar"><i class="bi bi-save me-2"></i>Guardar</button>
                    </div>
                    <div class="col-lg-3 d-grid mb-lg-0 mb-2">
                        <button type="button" class="btn btn-info"  id="btnBuscar"><i class="bi bi-search me-2"></i>Buscar</button>
                    </div>
                    <div class="col-lg-3 d-grid mb-lg-0 mb-2">
                        <button type="button" class="btn btn-warning" id="btnModificar"><i class="bi bi-pencil-square me-2"></i>Modificar</button>
                    </div>
                    <div class="col-lg-3 d-grid mb-lg-0 mb-2">
                        <button type="reset" class="btn btn-danger" id="btnLimpiar"><i class="bi bi-arrow-clockwise me-2"></i>Limpiar</button>
                    </div>
            </div>
    </form>
</div>
<div class="row" id="divTabla">
    <div class="col-lg-100">
        <table id="armasTabla" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>NOMBRE</th>
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script src="build/js/unidadmedida/index.js"></script>
