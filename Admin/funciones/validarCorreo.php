<?php 
    require "conecta.php";
    $con = conecta();
    $correo = $_REQUEST['correo'];
    $sql = "SELECT * FROM administradores WHERE correo = '$correo'";
    $res = $con->query($sql);

    $res2 = $res->fetch_array();
    $bandera = 0;
    if($res2['correo'] == $correo) {
       $bandera = 1;
    } else {
        $bandera = 0;
    }

    echo $bandera;
?>