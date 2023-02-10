<?php

namespace Model;

class Dinero extends ActiveRecord{

    protected static $tabla = 'amc_incautacion_dinero'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','CANTIDAD','MONEDA','CONVERSION','SITUACION'];

    public $id;
    public $topico;
    public $cantidad;
    public $moneda;
    public $conversion;
 
    public $destino;
 
    public $situacion;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topic'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->moneda = $args['moneda'] ?? '';  
        $this->conversion = $args['conversion'] ?? '';  
        $this->situacion = $args['situacion'] ?? '1';
    }

    public function validarConversion(){
        $array = $this->fetchArray("SELECT cambio from amc_migrantes where id = $this->moneda and situacion = 1 ");

        return $array;
        // return $array;
    }

    public function validarExisteTopico(){
        $array = $this->fetchArray("SELECT topic from amc_migrantes where topic = $this->topico and situacion = 1 ");

        return count($array) > 0;
        // return $array;
    }

}