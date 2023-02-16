<?php

namespace Model;

class Captura extends ActiveRecord{

    protected static $tabla = 'amc_capturas'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','INFO','SITUACION'];

    public $id;
    public $topico;
    public $info;
    public $situacion;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';
        $this->info = utf8_decode( $args['info'] ) ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

    public function validarExisteTopico(){
        $array = $this->fetchArray("SELECT topico from amc_capturas where topico = $this->topico and situacion = 1 ");

        return count($array) > 0;
        // return $array;
    }

}