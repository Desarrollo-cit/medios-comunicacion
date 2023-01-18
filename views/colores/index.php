<div class="row text-center">
    <div class="col">
        <h1>TIPOS DE COLORES</h1>
    </div>
</div>
<div class="row justify-content-center mb-3">
    <form id="formColores" class="col-lg-4 border rounded bg-light p-3">
        <input type="hidden" name="id" id="id">
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="marca">Descripcion del color</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="modelo">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control">
            </div>
        </div>

        <div class="mb-3">
          <label for="" class="form-label">Color</label>
          <input type="color" class="form-control" name="color" id="color" >
          
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="modelo">Nivel</label>
                <input type="number" name="nivel" id="nivel" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="topico" >Topico</label>
                <select name="topico" id="topico" class="form-control">
                    <option value="0">Seleccionar</option>
                    <?php
                    foreach ($busqueda as $fila) {
                        $id = $fila['id'];
                        $desc = $fila['desc'];
                        ?>

                        <option value="<?php echo $id?>"> <?php echo $desc?></option>

                <?php
                    }
                        
                    ?>


                </select>
                
                    
                    

                   
              
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button id="btnGuardar" type="submit" class="btn btn-primary w-100">Guardar Color</button>
            </div>
            <div class="col">
                <button id="btnModificar" type="button" class="btn btn-warning w-100" >Modificar Color</button>
            </div>
        </div>
       
        
    </form>
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
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script src="build/js/colores/index.js"></script>