<?php

namespace Model;

class Topico extends ActiveRecord{

    protected static $tabla = 'amc_topico'; //nombre de la tablaX
    protected static $columnasDB = ['ID','FECHA','LUGAR','DEPTO','MUNICIPIO', 'TIPO', 'LATITUD', 'LONGITUD', 'ACTIVIDAD', 'SITUACION'];

    public $id;
    public $fecha;
    public $lugar;
    public $depto;
    public $municipio;
    public $tipo;
    public $latitud;
    public $longitud;
    public $actividad;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->lugar = $args['lugar'] ?? '';
        $this->depto = $args['depto'] ?? '';
        $this->municipio = $args['municipio'] ?? '';
        $this->tipo = $args['tipo'] ?? '';
        $this->latitud = $args['latitud'] ?? '';
        $this->longitud = $args['longitud'] ?? '';
        $this->actividad = $args['actividad'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

}