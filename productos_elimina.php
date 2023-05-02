<?php
  require "funciones/conecta.php";
  $con = conecta();

  //recibe variables
  $id = $_REQUEST['id'];


  //$sql = "DELETE FROM productos WHERE id = $id";
  $sql = "UPDATE productos SET eliminado = 1 WHERE id = $id";
  $res = $con->query($sql);

  echo $res;
?>
