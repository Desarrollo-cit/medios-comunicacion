<?php

namespace Model;

class Muertes extends ActiveRecord{

    protected static $tabla = 'amc_per_asesinadas'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','ASESINATO','NOMBRE', 'EDAD',  'SEXO', 'SITUACION'];

    public $id;
    public $topico;
    public $asesinato;
    public $nombre;
    public $edad;
    public $sexo;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';
        $this->asesinato = $args['asesinato'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->edad = $args['edad'] ?? '';
        $this->sexo = $args['sexo'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

}