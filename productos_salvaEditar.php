<?php
    require "funciones/conecta.php";
    $con = conecta();

	//Recibe variables
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$descripcion = $_POST['descripcion'];
	$codigo = $_POST['codigo'];
	$stock = $_POST['stock'];
	$costo = $_POST['costo'];
	$archivo_n = '';
	$archivo = '';

	$file_name = $_FILES['archivo']['name'];    //Nombre real del archivo
	

	if($file_name != '')
	{
		$file_tmp = $_FILES['archivo']['tmp_name']; //Nombre temporal del archivo
		$cadena = explode(".", $file_name);         //Tomar solo el ultimo substrings tras "."
		$ext = $cadena[1];
		$dir = "imagenes/fotosProductos";
		$file_enc = md5_file($file_tmp);

		$fileName1 = "$file_enc" . "." . "$ext";
		copy($file_tmp, $dir.$fileName1);

		$archivo_n = $file_name;
		$archivo = $file_enc . "." . $ext; 

		$sql = "UPDATE productos
		SET archivo = '$archivo',
		archivo_n = '$archivo_n'
		WHERE id = '$id'
		AND eliminado = 0;";
		$num = $con->query($sql);
	}

	$sql = "UPDATE productos
		SET nombre = '$nombre',
		codigo = '$codigo',
		stock = '$stock',
		descripcion = '$descripcion',
		costo = '$costo'
		WHERE id = '$id'
		AND eliminado = 0;";
	
	$num = $con->query($sql);

	header("Location: productos_lista.php");
?>
