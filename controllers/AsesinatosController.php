<?php

namespace Controllers;

use Model\Asesinatos;
use Model\Asesinados;
use MVC\Router;
use Exception;

class AsesinatosController
{
    public static function guardar(){
        getHeadersApi();
        
        
        try {
            $Asesinatos = new Asesinatos([
                'topico' => $_POST['topico'],
                'info' => $_POST['info'],
            ]);

            if(!$Asesinatos->validarExisteTopico()){
                $guardado = $Asesinatos->guardar();
            }
            
            $cantidadAsesinados = count($_POST['nombre']);
            $resultados = [];
            for ($i=0; $i < $cantidadAsesinados ; $i++) { 
                $asesinados = new Asesinados([
                    'topico' => $_POST['topico'],
                    'nacionalidad' => $_POST['nacionalidad'][$i],
                    'sexo' => $_POST['sexo'][$i],
                    'nombre' => $_POST['nombre'][$i],
                    'edad' => $_POST['edad'][$i],
                    'delito' => $_POST['delito'][$i],
                    'vinculo' => $_POST['vinculo'][$i],
                ]);
                

                $guardado = $asesinados->guardar();
                $resultados[] = $guardado['resultado'];
            }

            // echo json_encode($resultados);


            if(!array_search(0, $resultados)){
                echo json_encode([
                    "mensaje" => "El registro se guardó.",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió  un error.",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }

    public static function buscarAsesinatosAPI(){

   
        getHeadersApi();
     
        $topico = $_GET['topico'];

        try{
            $asesinatos = Asesinatos::fetchArray("SELECT * FROM amc_asesinato where topico = $topico and situacion = 1;");


            $asesinados = Asesinados::fetchArray("SELECT * FROM amc_per_asesinadas where topico = $topico and situacion = 1;");

            echo json_encode([
                "asesinatos" => array_shift($asesinatos),
                "asesinados" => $asesinados,
            ]);

        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió  un error en base de datos.",

                "codigo" => 4,
            ]);
        }
    }
}