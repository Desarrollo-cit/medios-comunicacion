<?php

namespace Model;

class IncautacionMunicion extends ActiveRecord{

    protected static $tabla = 'amc_detalle_municion'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','CALIBRE','CANTIDAD','SITUACION'];

    public $id;
    public $topico;
    public $calibre;
    public $cantidad;
    public $situacion;
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';
        $this->calibre = $args['calibre'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->situacion = $args['situacion'] ?? '1';
    }
}