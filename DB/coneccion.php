<?php
require_once("constantes.php");
function conectar(){
    //echo "<br> CONEXION A LA BASE DE DATOS<br>";
    $c = new mysqli(SERVER, USER, PASS, BD);
    
    if($c->connect_errno) {
        die("Error de conexión: " . $c->connect_errno . ", " . $c->connect_error);
    }
    
    
    $c->set_charset("utf8");
    return $c;
}

$cn = conectar();