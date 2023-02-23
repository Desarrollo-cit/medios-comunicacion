<?php
namespace Controllers;
use MVC\Router;
use Model\Usuarios;
class usuariosController{
    public static function index(Router $router){
        $router->render('usuarios/index',[]);
    }
// Inicio de la funcion guardar usuarios
    public function guardarAPI(){
        getHeadersApi();

        try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            // echo json_encode($_POST);
            // exit;
            $usuarios = new Usuarios($_POST);
            
            $valor = $usuarios->desc;
            $existe = Usuarios::SQL("SELECT * from amc_usuarios where situacion = 1 AND desc = '$valor'");
            
            
            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El registro ya existe",
                   "codigo" => 2,
               ]);
               exit;
            }
             
            $resultado = $usuarios->guardar();
    
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
    
    // fin de la funcion guardar usuarios



    // inicio de la funcion
    public function buscarApi(){
        getHeadersApi();
        // echo json_encode("hola");
        //     exit;
        $usuarios = Usuarios::where('situacion', '0','>');
        echo json_encode($usuarios);
    }

    public function modificarAPI(){
        getHeadersApi();
       try {
            // $_POST["desc"] = strtoupper($_POST["desc"]);
            $usuarios = new Usuarios($_POST);
            $valor = $usuarios->desc;
            $existe = Usuarios::SQL("select * from amc_usuarios where situacion =1 AND desc = '$valor'");

            if (count($existe)>0){
               echo json_encode([
                   "mensaje" => "El valor no se modificó.",
                   "codigo" => 2,
               ]);
               exit;
            }
    
            $resultado = $usuarios->guardar();
    
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
        $usuarios = new Usuarios($_POST);
        
        $resultado = $usuarios->guardar();

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

    public function cambioSituacionAPI(){
        getHeadersApi();
        

    if ($_POST['situacion'] == 1){
        $_POST['situacion'] = 2;
    }else{
        $_POST['situacion'] = 1;

        }
        $usuarios = new Usuarios($_POST);
        $resultado = $usuarios->guardar();
        if($resultado['resultado'] == 1){
            echo json_encode([
                "resultado" => 1
            ]);
            
        }else{
            echo json_encode([
                "resultado" => 2
            ]);

        }
    }
}
?>