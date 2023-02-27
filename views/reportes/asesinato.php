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
<h3>DETALLE DE LAS MUERTES</h3>
<table cellspacing = 0 border="1" width="100%">
    <thead>
        <tr>
            <th>NO</th>
            <th>NOMBRE</th>
            <th>SEXO</th>
            <th>EDAD</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($asesinados as $key => $asesinado) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $asesinado['nombre'] ?></td>
                <td><?= $asesinado['sexo'] ?></td>
                <td><?= $asesinado['edad'] ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>