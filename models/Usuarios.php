<?php

namespace Model;

class Usuarios extends ActiveRecord{

    protected static $tabla = 'amc_usuarios'; //nombre de la tablaX
    protected static $columnasDB = ['ID','DESC','SITUACION'];

    public $id;
    public $desc;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->desc = utf8_decode(mb_strtoupper(trim($args['desc']))) ??'';
        $this->situacion = $args['situacion'] ?? '1';
    }

}