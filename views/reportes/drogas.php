<style>
    table, tr, td, th{
        border: 1px solid black;
        border-spacing: 0 ;
        border-collapse: collapse;
    }

    th{
        background-color: cadetblue;
    }

</style>
<h3>DETALLE DE INCAUTACION</h3>
<table cellspacing = 0 border="1" width="100%">
    <thead>
        <tr>
            <th>PLANTACIONES</th>
            <th>CANTIDAD</th>
            <th>EN POLVO</th>
            <th>CANTIDAD</th>
            <th>TRANPORTE</th>
            <th>TIPO DE TRANSPORTE</th>
            <th>MATRICULA</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($detalle) > 0) : ?>
        <?php foreach ($detalle as $key => $fila) : ?>
            <tr>
                <td><?= $fila['tipo_plantacion'] ?></td>
                <td><?= $fila['cantidad_plantacion'] ?></td>
                <td><?= $fila['tipo'] ?></td>
                <td><?= $fila['cantidad'] ?></td>
                <td><?= $fila['transporte'] ?></td>
                <td><?= $fila['tipo_transporte'] ?></td>
                <td><?= $fila['matricula'] ?></td>
            </tr>
        <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="6">NO HAY REGISTROS</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
<h3>DETALLE DE LA CAPTURA</h3>
<table cellspacing = 0 border="1" width="100%">
    <thead>
        <tr>
            <th>NO</th>
            <th>NOMBRE</th>
            <th>SEXO</th>
            <th>EDAD</th>
            <th>NACIONALIDAD</th>
            <th>DELITO</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($capturados) > 0) : ?>
        <?php foreach ($capturados as $key => $capturado) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $capturado['nombre'] ?></td>
                <td><?= $capturado['sexo'] ?></td>
                <td><?= $capturado['edad'] ?></td>
                <td><?= $capturado['nacionalidad'] ?></td>
                <td><?= $capturado['delito'] ?></td>
            </tr>
        <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="6">NO HAY REGISTROS</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>