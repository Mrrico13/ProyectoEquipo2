<?php
	require "Funciones/conecta.php";
	$con = conecta();

	$id= $_REQUEST['codigo'];

	$sql = "SELECT * FROM productos WHERE codigo = \"$id\" AND eliminado = 0 ";

	$num = $con->query($sql);
	
	$count = 0;
	foreach($num as $row)
	{
		$count = $row["stock"];
	}

	echo "$count";

	?>