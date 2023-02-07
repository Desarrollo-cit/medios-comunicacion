<?php

namespace Model;

class Delitos extends ActiveRecord{

    protected static $tabla = 'amc_delito'; //nombre de la tablaX
    protected static $columnasDB = ['ID','DESC','SITUACION'];

    public $id;
    public $desc;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        // $this->desc = $args['desc'] ?? null;
        $this->desc = utf8_decode(mb_strtoupper(trim($args['desc']))) ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

}