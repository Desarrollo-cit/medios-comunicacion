<?php

namespace Model;

class Capturadas extends ActiveRecord{

    protected static $tabla = 'amc_per_capturadas'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','NACIONALIDAD','SEXO','NOMBRE', 'EDAD', 'DELITO', 'VINCULO', 'SITUACION'];

    public $id;
    public $topico;
    public $nacionalidad;
    public $sexo;
    public $nombre;
    public $edad;
    public $delito;
    public $vinculo;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';
        $this->nacionalidad = $args['nacionalidad'] ?? '';
        $this->sexo = $args['sexo'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->edad = $args['edad'] ?? '';
        $this->delito = $args['delito'] ?? '';
        $this->vinculo = $args['vinculo'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

}