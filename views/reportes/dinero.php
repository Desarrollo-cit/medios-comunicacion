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
            <th>NO.</th>
            <th>CANTIDAD</th>
            <th>MONEDA</th>
            <th>CONVERSION A Q.</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($detalle) > 0) : ?>
        <?php foreach ($detalle as $key => $fila) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $fila['cantidad'] ?></td>
                <td><?= $fila['moneda'] ?></td>
                <td><?= $fila['conversion'] ?></td>
            </tr>
        <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="6">NO HAY REGISTROS</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>