<?php

namespace Model;

class DepMun extends ActiveRecord{

    protected static $tabla = 'depmun'; //nombre de la tablaX
    protected static $columnasDB = ['DM_CODIGO','DM_DESC_LG','DM_DESC_MD','DM_DESC_CT','DM_MUN_DEP'];

    public $dm_codigo;
    public $dm_desc_lg;
    public $dm_desc_md;
    public $dm_desc_ct;
    public $dm_mun_dep;



    public function __construct($args = []){
        $this->dm_codigo = $args['dm_codigo'] ?? null;
        $this->dm_desc_lg = $args['dm_desc_lg'] ?? '';
        $this->dm_desc_md = $args['dm_desc_md'] ?? '';
        $this->dm_desc_ct = $args['dm_desc_ct'] ?? '';
        $this->dm_mun_dep = $args['dm_mun_dep'] ?? '';
       
    }

}