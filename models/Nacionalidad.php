<?php

namespace Model;

class Nacionalidad extends ActiveRecord{

    protected static $tabla = 'amc_nacionalidad'; //nombre de la tablaX
    protected static $columnasDB = ['ID','DESC','PAIS','SITUACION'];

    public $id;
    public $desc;
    public $pais;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->desc = $args['desc'] ?? '';
        $this->pais = $args['pais'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

}