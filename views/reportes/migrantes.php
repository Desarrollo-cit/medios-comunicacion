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
<h3>DETALLE DE MIGRANTES</h3>
<table cellspacing = 0 border="1" width="100%">
    <thead>
        <tr>
            <th>NO</th>
            <th>RANGO DE EDAD</th>
            <th>CANTIDAD</th>
            <th>LUGAR DE INGRESO</th>
            <th>PAIS DE DESTINO</th>
            <th>PROCEDENCIA</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($migrantes) > 0) : ?>
        <?php foreach ($migrantes as $key => $migrante) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $migrante['edad'] ?></td>
                <td><?= $migrante['cantidad'] ?></td>
                <td><?= $migrante['lugar_ingreso'] ?></td>
                <td><?= $migrante['destino'] ?></td>
                <td><?= $migrante['procedencia'] ?></td>
            </tr>
        <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="6">NO HAY REGISTROS</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>