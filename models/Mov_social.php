<?php

namespace Model;

class Mov_social extends ActiveRecord{

    protected static $tabla = 'amc_movimiento_social'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','TIPO_MOVIMIENTO', 'ORGANIZACION','CANTIDAD','SITUACION'];

    public $id;
    public $topico;
    public $tipo_movimiento;
    public $organizacion;
    public $cantidad;
    public $situacion;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';
        $this->tipo_movimiento= $args['tipo_movimiento'] ?? '';
        $this->organizacion= $args['organizacion'] ?? '';
        $this->cantidad= $args['cantidad'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

  


}