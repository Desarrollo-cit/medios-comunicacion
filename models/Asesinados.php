<?php

namespace Model;

class Asesinados extends ActiveRecord{

    protected static $tabla = 'amc_per_asesinadas'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','NOMBRE','EDAD','SEXO','SITUACION'];

    public $id;
    public $topico;
    public $nombre;
    public $edad;
    public $sexo;
   


    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';

        $this->sexo = $args['sexo'] ?? '';
        $this->nombre = utf8_decode($args['nombre']) ?? '';
        $this->edad = $args['edad'] ?? '';

        $this->situacion = $args['situacion'] ?? '1';
    }

}