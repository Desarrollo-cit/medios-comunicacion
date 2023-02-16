<style>
    
    table, tr, td, th{
        border: 1px solid black;
        border-spacing: 0 ;
        border-collapse: collapse;
        font-size:x-small;
    }

    h3{
        text-align: center;
    }

    th{
        background-color: cadetblue;
    }

</style>

<?php if ($inicio != '' && $fin != '') :?>
<h3>TÓPICOS INGRESADOS DEL <?= strtoupper(strftime('%d%H%M%b%Y',strtotime($inicio))) ?> AL <?= strtoupper(strftime('%d%H%M%b%Y',strtotime($fin))) ?></h3>
<?php elseif ($inicio != '' && $fin == '') : ?>
<h3>TÓPICOS INGRESADOS A PARTIR DEL <?= strtoupper(strftime('%d%H%M%b%Y',strtotime($inicio))) ?></h3>
<?php elseif ($inicio == '' && $fin != '') : ?>
<h3>TÓPICOS INGRESADOS HASTA EL <?= strtoupper(strftime('%d%H%M%b%Y',strtotime($fin))) ?></h3>
<?php else : ?>
<h3>TÓPICOS INGRESADOS</h3>
<?php endif?>
<table cellspacing = 0 border="1" width="100%">
    <thead>
        <tr>
            <th>NO</th>
            <th>FECHA Y HORA</th>
            <th>TIPO</th>
            <th>LUGAR</th>
            <th>DEPARTAMENTO/MUNICIPIO</th>
            <th>ACTIVIDAD VINCULADA</th>
            <th>LATITUD</th>
            <th>LONGITUD</th>

        </tr>
    </thead>
    <tbody >
        <?php if(count($eventos) > 0) : ?>
        <?php foreach ($eventos as $key => $evento) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $evento['fecha'] ?></td>
                <td><?= $evento['tipo'] ?></td>
                <td><?= $evento['lugar'] ?></td>
                <td><?= $evento['municipio'] ?></td>
                <td><?= $evento['actividad'] ?></td>
                <td><?= $evento['latitud'] ?></td>
                <td><?= $evento['longitud'] ?></td>

            </tr>
        <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="6">NO HAY REGISTROS</td>
            </tr>
        <?php endif ?>
    </tbody>
</table>