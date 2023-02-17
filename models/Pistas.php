<?php

namespace Model;

class Pistas extends ActiveRecord{

    protected static $tabla = 'amc_destruccion_pista'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','DISTANCIA', 'SITUACION'];

    public $id;
    public $topico;
    public $distancia;
    public $situacion;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';
        $this->distancia= $args['distancia'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

  


}