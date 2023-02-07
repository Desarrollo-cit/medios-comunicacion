<?php

namespace Model;

class Armas extends ActiveRecord{

    protected static $tabla = 'amc_tipo_armas'; //nombre de la tablaX
    protected static $columnasDB = ['ID','DESC','SITUACION'];

    public $id;
    public $desc;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        // $this->desc = $args['desc'] ?? '';
        $this->desc = utf8_decode(mb_strtoupper(trim($args['desc']))) ??'';
        $this->situacion = $args['situacion'] ?? '1';
    }

}