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