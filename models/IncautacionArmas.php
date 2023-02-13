<?php

namespace Model;

class IncautacionArmas extends ActiveRecord{

    protected static $tabla = 'amc_detalle_arma'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','TIPO_ARMA','CALIBRE','CANTIDAD','SITUACION'];

    public $id;
    public $topico;
    public $tipo_arma;
    public $calibre;
    public $cantidad;
    public $situacion;
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';
        $this->tipo_arma = $args['tipo_arma'] ?? '';
        $this->calibre = $args['calibre'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }
}