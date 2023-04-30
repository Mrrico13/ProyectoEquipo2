<?php
	require "Funciones/conecta.php";
	$con = conecta();

	$id_usuario = $_REQUEST['id_usuario'];

	$sql = "SELECT * FROM pedidos WHERE id_usuario = $id_usuario AND estado = 0 ";

	$num = $con->query($sql);

	$count = $num->fetch_array();

	$id_pedido = 0;
	foreach($num as $row)
	{
		if($row["id"] > 0)
		{
			$id_pedido = $row["id"];
		}
	}
	$sql = "SELECT * FROM pedidos_productos
	WHERE id_pedido = $id_pedido AND eliminado = 0";

	$res = $con->query($sql);

	$count = 0;
	foreach($res as $row)
	{
		$count += $row["precio"] * $row["cantidad"];
	}
	echo "$count";

	?>