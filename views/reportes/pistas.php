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
            <th>DISTANCIA</th>

        </tr>
    </thead>
    <tbody >
        <?php if(count($pistas) > 0) : ?>
        <?php foreach ($pistas as $key => $pista) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $pista['distancia'] ?></td>

            </tr>
        <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="6">NO HAY REGISTROS</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>