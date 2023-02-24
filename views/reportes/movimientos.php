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
<h3>DETALLE DEL MOVIMIENTO SOCIAL</h3>
<table cellspacing = 0 border="1" width="100%">
    <thead>
        <tr>
            <th>NO</th>
            <th>TIPO</th>
            <th>CANTIDAD DE PERSONAS</th>
            <th>ORGANIZACIÓN</th>

        </tr>
    </thead>
    <tbody >
        <?php if(count($movimientos) > 0) : ?>
        <?php foreach ($movimientos as $key => $movimientos) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $movimientos['tipo'] ?></td>
                <td><?= $movimientos['cantidad'] ?></td>
                <td><?= $movimientos['organizacion'] ?></td>

            </tr>
        <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="6">NO HAY REGISTROS</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>