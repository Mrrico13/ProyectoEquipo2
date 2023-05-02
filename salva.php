<?php
require "funciones/conecta.php";
$con = conecta();

//variables
$nombre = $_REQUEST['nombre'];
$apellidos = $_REQUEST['apellidos'];
$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass'];
$rol = $_REQUEST['rol'];
$archivo_n = '';
$archivo = '';
$passEnc = md5($pass);

$sql = "INSERT INTO administradores (nombre, apellidos, correo, pass, rol, archivo_n, archivo)
        VALUES ('$nombre', '$apellidos', '$correo', '$passEnc', $rol, '$archivo_n', '$archivo')";
$con->query($sql);

header("Location: administradores_lista.php");

?>
