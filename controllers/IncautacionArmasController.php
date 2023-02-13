<?php
namespace Controllers;


use Model\Evento;
use Model\IncautacionArmas;
use Model\IncautacionMunicion;
use Exception;
use MVC\Router;

class IncautacionArmasController
{
    public static function guardar(){
        getHeadersApi();

        try {

            $evento = Evento::find($_POST['topico']);
            $evento->info = $_POST['info'];
            $evento->guardar();

 
            $cantidadArmas = count($_POST['calibre']);
            $cantidadMunicion = count($_POST['calibre_municion']);
            $resultadosArmas = [];
            for ($i=0; $i < $cantidadArmas ; $i++) { 
                $armas = new IncautacionArmas([
                    'topico' => $_POST['topico'],
                    'tipo_arma' => $_POST['tipo'][$i],
                    'calibre' => $_POST['calibre'][$i],
                    'cantidad' => $_POST['cantidad'][$i],
            
                ]);
                

                $guardadoArmas = $armas->guardar();
                $resultadosArmas[] = $guardadoArmas['resultado'];
            }
            $resultadosMunicion = [];
            for ($i=0; $i < $cantidadMunicion ; $i++) { 
                $municion = new IncautacionMunicion([
                    'topico' => $_POST['topico'],
                    'calibre' => $_POST['calibre'][$i],
                    'cantidad' => $_POST['cantidad'][$i],
            
                ]);
                

                $guardadoMunicion = $municion->guardar();
                $resultadosMunicion[] = $guardadoMunicion['resultado'];
            }

            // echo json_encode($resultados);


            if(!array_search(0, $resultadosArmas) && !array_search(0, $resultadosMunicion)){
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
}