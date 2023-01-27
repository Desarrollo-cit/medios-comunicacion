<div class="row text-center">
    <div class="col">
        <h1>Nacionalidad</h1>
    </div>
</div>
<div class="row justify-content-center">
    <form id="formNacionalidad" class="col-lg-4 border rounded bg-light p-3">
        <input type="hidden" name="id" id="id">
        <div class="row mb-3">
            <div class="col-lg-12">
            <label for="pais">Pais</label>
            
                                    <select name="pais" id="pais" selected class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($busqueda as $pai) { ?>
                                            <option value="<?= $pai['pai_codigo']  ?>"><?= $pai['pai_desc_lg']?></option>
                                        <?php  }  ?>
                                    </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="desc">Nacionalidad</label>
                <input type="text" name="desc" id="desc" class="form-control" style="text-transform:uppercase">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button id="btnGuardar" type="submit" class="btn btn-primary w-100">Guardar</button>
            </div>
            <div class="col">
                <button id="btnModificar" type="button" class="btn btn-warning w-100">Modificar</button>
            </div>
        </div>
    </form>
</div>
<div class="row" id="divTabla">
    <div class="col-lg-100">
        <table id="nacionalidadTabla" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>PAIS</th>
                    <th>NACIONALIDAD</th>
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script src="build/js/nacionalidad/index.js"></script>