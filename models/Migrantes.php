<?php

namespace Model;

class Migrantes extends ActiveRecord{

    protected static $tabla = 'amc_migrantes'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPIC','PAIS_MIGRANTE','EDAD','CANTIDAD','SEXO','LUGAR_INGRESO','DESTINO','SITUACION'];

    public $id;
    public $topic;
    public $pais_migrante;
    public $edad;
    public $cantidad;
    public $sexo;
    public $lugar_ingreso;
    public $destino;
 
    public $situacion;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topic = $args['topic'] ?? '';
        $this->pais_migrante = $args['pais_migrante'] ?? '';
        $this->edad = $args['edad'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->sexo = $args['sexo'] ?? '';
        $this->lugar_ingreso = utf8_decode($args['lugar_ingreso']) ?? '';
        $this->destino = $args['destino'] ?? '';
     
        $this->situacion = $args['situacion'] ?? '1';
    }

    public function validarExisteTopico(){
        $array = $this->fetchArray("SELECT topic from amc_migrantes where topic = $this->topic and situacion = 1 ");

        return count($array) > 0;
        // return $array;
    }

}