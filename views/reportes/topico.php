<style>
    p{
        line-height: -1;
    }
    h2{
        text-align: center;
    }
</style>
<h2>REPORTE DEL TÓPICO</h2>
<p>
    <b>FECHA:</b>
    <?= $evento['fecha'] ?>
</p>

<p>
    <b>LUGAR:</b>
    <?=$evento['lugar'] ?>
</p>
<p>
    <b>TÓPICO:</b>
    <?= $evento['tipo_id'] ?>
</p>

<p>
    <b>MUNICIPIO:</b>
    <?= $evento['municipio'] ?>
</p>

<p>
    <b>ACTIVIDAD VINCULADA:</b>
    <?= $evento['actividad'] ?>
</p>

<pre>

    <?php print_r($detalle) ?>
</pre>