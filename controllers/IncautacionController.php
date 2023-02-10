<?php
namespace Controllers;

use Model\Capturados;
use Model\Evento;
use Model\Incautacion;
use MVC\Router;

class IncautacionController
{

    public static function guardar(){
        getHeadersApi();
        // echo json_encode($_POST)   ;
        try {

            $evento = Evento::find($_POST['topico']);
            $evento->info = $_POST['info'];
            $evento->guardar();

            $incautacion = new Incautacion([
                'topico' => $_POST['topico'],
                'tipo_droga' => $_POST['tipo_droga'],
                'transporte' => $_POST['transporte'],
                'matricula' => $_POST['matricula'],
                'tipo_transporte' => $_POST['tipo_transporte'],
                'cantidad' => $_POST['cantidad'],
                'tip_droga_plantacion' => $_POST['tipo_droga_plantacion'],
                'cantidad_plantacion' => $_POST['cantidad_plantacion'],
            ]);

            $incautacion->guardar();
 
            $cantidadCapturados = count($_POST['nombre']);
            $resultados = [];
            for ($i=0; $i < $cantidadCapturados ; $i++) { 
                $capturado = new Capturados([
                    'topico' => $_POST['topico'],
                    'nacionalidad' => $_POST['nacionalidad'][$i],
                    'sexo' => $_POST['sexo'][$i],
                    'nombre' => $_POST['nombre'][$i],
                    'edad' => $_POST['edad'][$i],
                    'delito' => $_POST['delito'][$i],
                    'vinculo' => $_POST['vinculo'][$i],
                ]);
                

                $guardado = $capturado->guardar();
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

    public static function buscarIncautacionAPI(){
        getHeadersApi();
        $topico = $_GET['topico'];

        try{
            $evento = Evento::find($topico);

            $incautacion = Incautacion::where('topico', $topico);
            $capturados = Capturados::fetchArray("SELECT * FROM amc_per_capturadas where topico = $topico and situacion = 1;");

            echo json_encode([
                "evento" => $evento,
                "incautacion" => array_shift($incautacion),
                "capturados" => $capturados,
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