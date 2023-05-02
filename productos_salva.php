<?php
    require "funciones/conecta.php";
    $con = conecta();

    $nombre = $_REQUEST['nombre'];
    $descripcion = $_REQUEST['descripcion'];
    $codigo = $_REQUEST['codigo'];
    $costo = $_REQUEST['costo'];
    $stock = $_REQUEST['stock'];
    $archivo_n = $_FILES['foto']['name'];
    $archivo_temp = $_FILES['foto']['tmp_name'];
    $ext = pathinfo($archivo_n, PATHINFO_EXTENSION);
    $dir = "imagenes/fotosProductos/";
    $archivo = md5_file($archivo_temp);

    if ($archivo_n != '') {
        $file_Name1 = "$archivo.$ext";
        copy($archivo_temp, $dir.$file_Name1);
    }

    $sql = "INSERT INTO productos
    (nombre, descripcion, codigo, costo, stock, archivo_n, archivo)
    VALUES ('$nombre', '$descripcion', '$codigo', '$costo', $stock, '$archivo_n', '$file_Name1')";

    $res = $con->query($sql);

    header("Location: productos_lista.php");
?>
