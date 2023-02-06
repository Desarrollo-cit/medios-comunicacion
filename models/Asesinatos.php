<?php

namespace Model;

class Asesinatos extends ActiveRecord{

    protected static $tabla = 'amc_capturas'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','CANT_PER_ASESINADAS','INFO','SITUACION'];

    public $id;
    public $topico;
    public $cant_per_asesinadas;
    public $info;
    public $situacion;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';
        $this->cant_per_asesinadas = $args['cant_per_asesinadas'] ?? '';
        $this->info = $args['info'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

    public function validarExisteTopico(){
        $array = $this->fetchArray("SELECT topico from amc_asesinatos where topico = $this->topico and situacion = 1 ");

        return count($array) > 0;
        // return $array;
    }

}