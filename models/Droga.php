<?php

namespace Model;

class Droga extends ActiveRecord{

    protected static $tabla = 'amc_incautacion_droga'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','TIPO_DROGA','TRANSPORTE','MATRICULA', 'TIPO_TRANSPORTE', 'CANTIDAD', 'TIP_DROGA_PLANTACION', 'INFO','
    SITUACION'];

    public $id;
    public $topico;
    public $tipo_droga;
    public $transporte;
    public $matricula;
    public $tipo_transporte;
    public $cantidad;
    public $tip_droga_plantacion;
    public $info;
    public $situacion;


    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';
        $this->tipo_droga = $args['tipo_droga'] ?? '';
        $this->transporte = $args['transporte'] ?? '';
        $this->matricula = $args['matricula'] ?? '';
        $this->tipo_transporte = $args['tipo_transporte'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->tip_droga_plantacion = $args['tip_droga_plantacion'] ?? '';
        $this->info = $args['info'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }

}