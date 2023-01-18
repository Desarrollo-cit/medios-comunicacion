<?php

namespace Model;

class Tipo extends ActiveRecord{

    protected static $tabla = 'amc_tipo_movimiento_social'; //nombre de la tablaX
    protected static $columnasDB = ['ID','DESC','SITUACION'];

    public $id;
    public $desc;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->desc = $args['desc'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

}