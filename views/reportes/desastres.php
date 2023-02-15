<style>
    table, tr, td, th{
        border: 1px solid black;
        border-spacing: 0 ;
        border-collapse: collapse;
    }

    td{
        text-align: center;
    }

    th{
        background-color: cadetblue;
    }

</style>
<h3>DETALLE DEL DESASTRE</h3>
<table cellspacing = 0 border="1" width="100%">
    <thead>
        <tr>
            <th>NO</th>
            <th>TIPO</th>
            <th>FENOMENO NATURAL</th>
            <th>FALLECIDOS</th>
            <th>EVACUADOS</th>
            <th>AFECTADOS</th>
            <th>ALBERGUES</th>
            <th>ESTRUCTURAS COLAPSADAS</th>
            <th>INUNDACIONES</th>
            <th>DERRUMBES</th>
            <th>CARRETERAS COLAPSADAS</th>
            <th>HECTAREAS QUEMADAS</th>
            <th>RIOS DESBORDADOS</th>
        </tr>
    </thead>
    <tbody >
        <?php if(count($desastres) > 0) : ?>
        <?php foreach ($desastres as $key => $desastre) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $desastre['tipo_desastre'] ?></td>
                <td><?= $desastre['fenomeno'] ?></td>
                <td><?= $desastre['per_fallecida'] ?></td>
                <td><?= $desastre['per_evacuada'] ?></td>
                <td><?= $desastre['per_afectada'] ?></td>
                <td><?= $desastre['albergues'] ?></td>
                <td><?= $desastre['est_colapsadas'] ?></td>
                <td><?= $desastre['inundaciones'] ?></td>
                <td><?= $desastre['derrumbes'] ?></td>
                <td><?= $desastre['carre_colap'] ?></td>
                <td><?= $desastre['hectareas_quemadas'] ?></td>
                <td><?= $desastre['rios'] ?></td>
            </tr>
        <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="6">NO HAY REGISTROS</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>