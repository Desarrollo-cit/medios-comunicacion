<?php

namespace Model;

class Evento extends ActiveRecord{
    protected static $tabla = 'amc_topico'; //nombre de la tablaX
    protected static $columnasDB = ['ID','FECHA','LUGAR', 'DEPARTAMENTO','MUNICIPIO','TIPO','LATITUD','LONGITUD','ACTIVIDAD','SITUACION','INFO', 'DEPENDENCIA','FUENTE','USUARIO','LINK'];

    public $id;
    public $fecha;
    public $lugar;
    public $departamento;
    public $municipio;
    public $tipo;
    public $latitud;
    public $longitud;
    public $actividad;
    public $situacion;
    public $info;
    public $dependencia;
    public $fuente;
    public $usuario;
    public $link;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->lugar = utf8_decode( mb_strtoupper($args['lugar'])) ?? '';
        $this->departamento = $args['departamento'] ?? '';
        $this->municipio = $args['municipio'] ?? '';
        $this->tipo = $args['tipo'] ?? '';
        $this->latitud = $args['latitud'] ?? '';
        $this->longitud = $args['longitud'] ?? '';
        $this->actividad = $args['actividad'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
        $this->info = utf8_decode( preg_replace("[\n|\r|\n\r]", "", htmlspecialchars($args['info']))) ?? '';
        $this->dependencia = $args['dependencia'] ?? '';
        $this->fuente = $args['fuente'] ?? '';
        $this->usuario = $args['usuario'] ?? '';
        $this->link = $args['link'] ?? '';
    }

    public function setInfo($info){
        $this->info = utf8_decode( preg_replace("[\n|\r|\n\r]", "", htmlspecialchars($info)));
    }
}