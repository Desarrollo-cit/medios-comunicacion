<?php

namespace Model;

class Moneda extends ActiveRecord{

    protected static $tabla = ' amc_moneda'; //nombre de la tablaX
    protected static $columnasDB = ['ID','DESC','CAMBIO','SITUACION'];

    public $id;
    public $desc;
    public $cambio;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->desc = $args['desc'] ?? '';
        $this->cambio = $args['cambio'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

}