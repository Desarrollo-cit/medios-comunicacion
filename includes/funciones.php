<?php

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() {
    session_start();
    if(!isset($_SESSION['auth_user'])) {
        header('Location: /');
    }
}
function isAuthApi() {
    session_start();
    if(!isset($_SESSION['auth_user'])) {
        echo json_encode(["error" => "NO AUTENTICADO"]);
        exit;
    }
}

function isNotAuth(){
    session_start();
    if(isset($_SESSION['auth'])) {
        header('Location: /auth/');
    }
}

function hasPermission(array $permisos){
    foreach ($permisos as $permiso) {
        if(!isset($_SESSION[$permiso])){
            header('Location: /');
        }
    }
}

function hasPermissionApi(array $permisos){
    foreach ($permisos as $permiso) {
        if(!isset($_SESSION[$permiso])){
            echo json_encode(["error" => "NO TIENE PERMISOS"]);
            exit;
        }
    }
}

function getHeadersApi(){
    return header("Content-type:application/json; charset=utf-8");
}

function asset($ruta){
    return "/". $_ENV['APP_NAME']."/public/" . $ruta;
}