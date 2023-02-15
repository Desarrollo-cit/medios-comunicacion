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
<h3>DETALLE DE LAS ARMAS INCAUTADAS</h3>
<table cellspacing = 0 border="1" width="100%">
    <thead>
        <tr>
            <th>NO.</th>
            <th>TIPO</th>
            <th>CALIBRE</th>
            <th>CANTIDAD</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($armas) > 0) : ?>
        <?php foreach ($armas as $key => $arma) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $arma['tipo'] ?></td>
                <td><?= $arma['calibre'] ?></td>
                <td><?= $arma['cantidad'] ?></td>
            </tr>
        <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="6">NO HAY REGISTROS</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
<h3>DETALLE DE LA MUNICIÓN INCAUTADA</h3>
<table cellspacing = 0 border="1" width="100%">
    <thead>
        <tr>
            <th>NO.</th>
            <th>CALIBRE</th>
            <th>CANTIDAD</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($municiones) > 0) : ?>
        <?php foreach ($municiones as $key => $municion) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $municion['calibre'] ?></td>
                <td><?= $municion['cantidad'] ?></td>
            </tr>
        <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="6">NO HAY REGISTROS</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>