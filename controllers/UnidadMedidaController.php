<?php
namespace Controllers;

use MVC\Router;
use model\UnidadMedida;
class UnidadMedidaController{

    public static function index(Router $router){
        $router->render('UnidadMedida/index');
    }
    public function guardarAPI(){
        getHeadersApi();

        try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $unidadmedida = new UnidadMedida($_POST);
            $valor = $_POST["desc"];
            $existe = UnidadMedida::SQL("select * from codemar_unidades_medida where uni_situacion = 1 AND uni_desc = '$valor'");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $unidadmedida->guardar();
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro se guardo",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió un error",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió un error en base de datos",

                "codigo" => 4,
            ]);
        }
        
    }
    public function buscarApi(){
        getHeadersApi();
        $unidadmedida = UnidadMedida::where('situacion', '1');
        echo json_encode($unidadmedida);
    }

    public function modificarAPI(){
        getHeadersApi();
       try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $unidadmedida = new UnidadMedida($_POST);
            $valor = $_POST["desc"];
            $existe = Armas::SQL("select * from codemar_unidades_medida where uni_situacion = 1 AND uni_desc = '$valor'");
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $armas->guardar();
    
            if($resultado['resultado'] == 1){
                echo json_encode([
                    "mensaje" => "El registro se guardo",
                    "codigo" => 1,
                ]);
                
            }else{
                echo json_encode([
                    "mensaje" => "Ocurrió un error",
                    "codigo" => 0,
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Ocurrió un error en base de datos",

                "codigo" => 4,
            ]);
        }
    }

    public function eliminarAPI(){
        getHeadersApi();
        $_POST['situacion'] = 0;
        $armas = new Armas($_POST);
        
        $resultado = $armas->guardar();

        if($resultado['resultado'] == 1){
            echo json_encode([
                "resultado" => 1
            ]);
            
        }else{
            echo json_encode([
                "resultado" => 0
            ]);

        }
    }

}
?>