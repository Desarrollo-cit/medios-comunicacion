<?php

namespace Model;

class Des_natural extends ActiveRecord{

    protected static $tabla = 'amc_desastre_natural'; //nombre de la tablaX
    protected static $columnasDB = ['ID','TOPICO','TIPO','NOMBRE_DESASTRE','PER_FALLECIDA','PER_EVACUADA', 'PER_AFECTADA','ALBERGUES','EST_COLAPSADAS','INUNDACIONES','DERRUMBES','CARRE_COLAP','HECTAREAS_QUEMADAS', 'RIOS', 'SITUACION'];

    public $id;
    public $topico;
    public $tipo;
    public $nombre_desastre;
    public $per_fallecida;
    public $per_evacuada;
    public $per_afectada;
    public $albergues;
    public $est_colapsadas;
    public $inundaciones;
    public $derrumbes;
    public $carre_colap;
    public $hectareas_quemadas;
    public $rios;
    public $situacion;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->topico = $args['topico'] ?? '';
        $this->tipo= $args['tipo'] ?? '';
        $this->nombre_desastre = $args['nombre_desastre'] ?? '';
        $this->per_fallecida = $args['per_fallecida'] ?? '';  
        $this->per_evacuada = $args['per_evacuada'] ?? '';  
        $this->per_afectada = $args['per_afectada'] ?? '';  
        $this->albergues = $args['albergues'] ?? '';  
        $this->est_colapsadas = $args['est_colapsadas'] ?? '';  
        $this->inundaciones = $args['inundaciones'] ?? '';  
        $this->derrumbes = $args['derrumbes'] ?? '';  
        $this->carre_colap = $args['carre_colap'] ?? '';  
        $this->hectareas_quemadas = $args['hectareas_quemadas'] ?? '';  
        $this->rios = $args['rios'] ?? '';  
        $this->situacion = $args['situacion'] ?? '1';
    }

  
    // public function validarExisteTopico(){
    //     $array = $this->fetchArray("SELECT topic from amc_desastre_natural where topico = $this->topico and situacion = 1 ");

    //     return count($array) > 0;
    //     // return $array;
    // }

}