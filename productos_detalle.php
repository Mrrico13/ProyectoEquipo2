<title>Detalles de producto</title>
<style>
  .divIzq{
      margin: 2% 0px 0px 5%;
  }

  body{
    background-color: lightcyan;
    margin: 0;
    height: 100vh;
    box-sizing: border-box;
  }

  a{
      color: black;
      font-weight: bold;
  }

  a:hover{
      color: blue;
  }

  a:active{
      color: red;
  }

  .carta{
      width: 300px;
      height: 400px;
      background: #FFF;
      border-radius: 6px;
      position: absolute;
      top: 62%;
      left: 50%;
      transform: translate(-50%,-50%);
      overflow: hidden;

  }
  .cont-arriba{
      height: 130px;
      background: #2A0D5D;
  }
  .cont-img img{
      width: 80px;
      height: 80px;
      border-radius: 50%;
  }
  .cont-img{
      background: white;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      padding: 5px;
      transform: translate(100px,100px);
  }
  .cont-abajo{
      height: 280px;
      background: #F8DC75;
      padding: 20px;
      padding-top: 50px;
  }

  .cont-abajo p{
      font-size: 16px;
      color: black;
      display: inline;
  }
  .cont-abajo h4{
      color: black;
      font-weight: lighter;
      text-align: left;
      display: inline;
      line-height: 1.5;
  }

</style>

<?php
    require "funciones/conecta.php";
    $con = conecta();
    $id = $_REQUEST['id'];
    $sql = "SELECT * FROM productos WHERE id = $id";
    $res = $con->query($sql);

    $row = $res->fetch_array();
    $foto = $row["archivo"];
    $nombre = $row["nombre"];
    $descripcion = $row["descripcion"];
    $codigo = $row["codigo"];
    $stock = $row["stock"];
    $costo = $row["costo"];

    echo "<div class='link divIzq'><a href=\"productos_lista.php\">Regresar al listado</a></div><br>";
    echo "<div align='center' style='font-weight: bold; font-size: 40px;'>Detalles del Productos:</div><br>";
    echo "<HR noshade align='center' style='margin-bottom: 30;'>";

    echo "<div class='carta'>
            <div class='cont-arriba'>
                <div class='cont-img'>
                <img src='imagenes/fotosProductos/$foto'/>
                </div>
            </div>
            <div class='cont-abajo'>
                <div>
                    <h3>$nombre</h3>
                    <h4 style='margin-right: 10px;'>codigo:</h4>
                    <p>$codigo</p>
                    <br>
                    <p>$descripcion</p>
                    <br>
                    <h4 style='margin-right: 31px;'>stock:</h4>
                    <p>$stock</p>
                    <br>
                    <h4 style='margin-right: 15px;'>costo:</h4>
                    <p>$costo</p>
                </div>
            </div>
        </div>";
?>
