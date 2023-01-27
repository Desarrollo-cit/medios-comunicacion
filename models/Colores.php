<?php

namespace Model;

class Colores extends ActiveRecord
{

    protected static $tabla = 'amc_colores'; //nombre de la tablaX
    protected static $columnasDB = ['ID', 'DESCRIPCION', 'CANTIDAD', 'COLOR', 'NIVEL', 'TOPICO', 'SITUACION'];

    public $id;
    public $descripcion;
    public $cantidad;
    public $color;
    public $nivel;
    public $topico;
    public $situacion;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->color = $args['color'] ?? '';
        $this->nivel = $args['nivel'] ?? '';
        $this->topico = $args['topico'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }
}
