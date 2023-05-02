<script src="js/jquery-3.3.1.min.js"></script>
<script>
            function eliminar(idE) {
                var id = idE;
                if(id) {
                    var mensaje = confirm("¿Esta seguro de querer eliminar este registro de la tabla?");
                    if (mensaje) {
                        $.ajax ({
                            url     : 'productos_elimina.php',
                            type    : 'post',
                            datatype : 'text',
                            data    : 'id='+id,
                            success : function(res) {
                                $("#tr" + id).hide();
                                $('#mensaje').html('<img src="imagenes/loader2.gif"/>');
                                setTimeout("$('#mensaje').html('')",5000);
                                alert("Registro eliminado con exito");
                            },error: function() {
                                alert('Error archivo no encontrado...');
                            }
                        });
                    }
                    else {
                        alert("El registro no se ha eliminado");
                    }
                } else {
                    $('#mensaje').html('Ha ocurrido un error');
                }
            }
    </script>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Listado de productos</title>
<style>
    .divDer{
        margin: 0px 0px 0px 83%;
    }
    .divIzq {
        margin: 2% 0px 0px 5%;
    }

    .tabla {
        display: table;
        width: 1200px;
        margin: auto;
    }

    .head{
        display: table-row;
        text-align: center;
        line-height: 50px;
        height: 50px;
        background-color: pink;
    }

    .filas1{
        display: table-row;
        background-color: #FFEA61;
    }

    .filas2 {
        display: table-row;
        background-color: #FFFFB7;
    }

    .celdas {
        display: table-cell;
        border: 1px solid black;
        text-align: center;
        vertical-align: middle;
        width: 15%;
    }

    body {
        background-color:#c3e7fd;
    }

    a{
        color: black;
        font-weight: bold;
    }

    a:hover {
        color: blue;
    }

    a:active {
        color: red;
    }



    #mensaje {
        color: #F00;
        font-size: 18px;
        font-weight: bold;
        width: 400px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        margin:15px auto;
      }

      .cab{
        width:50%;
        border:1px dotted #f00;
        padding:8px;
        margin:auto;
        text-align: center;
        background: pink;
      }
</style>

  </head>
  <body>
  <?php
    //productos_lista.php
    require "funciones/conecta.php";
    $con = conecta();

    $sql = "SELECT * FROM productos WHERE status = 1 AND eliminado = 0";

    $res = $con->query($sql);

    echo "<div align='center' style='font-weight: bold; font-size: 40px; margin-top: 30;'>Listado de productos</div><br>";
    echo "<div class='link divIzq'><a href=\"../bienvenido.php\">Regresar al menú</a></div><br><br>";
    echo "<div class='link divDer'><a href=\"productos_alta.php\">Crear nuevo registro</a></div><br><br>";


    echo "<div class='tabla'>
        <div class='head'>
            <div class='celdas'>ID</div>
            <div class='celdas'>Nombre</div>
            <div class='celdas'>Codigo</div>
            <div class='celdas'>Stock</div>
            <div class='celdas'>Eliminar Registro</div>
            <div class='celdas'>Ver Detalles del Registro</div>
            <div class='celdas'>Editar Registro</div>
        </div>";
            while($row = $res->fetch_array()){
                $id = $row["id"];
                $nombre = $row["nombre"];
                $codigo = $row["codigo"];
                $stock = $row["stock"];

                if($id%2==0) {
                    echo "<div class='filas1' id='tr$id'>
                        <div class='celdas'>$id</div>
                        <div class='celdas'>$nombre</div>
                        <div class='celdas'>$codigo</div>
                        <div class='celdas'>$stock</div>
                        <div class='celdas'><a href='javascript:void(0);', onClick='eliminar($id);'>Eliminar</a></div>
                        <div class='celdas'><a href=\"productos_detalle.php?id=$id\">Ver detalle</a></div>
                        <div class='celdas'><a href=\"productos_edita.php?id=$id\">Editar</a></div>
                    </div>";
                } else {
                    echo "<div class='filas2' id='tr$id'>
                        <div class='celdas'>$id</div>
                        <div class='celdas'>$nombre</div>
                        <div class='celdas'>$codigo</div>
                        <div class='celdas'>$stock</div>
                        <div class='celdas'><a href='javascript:void(0);', onClick='eliminar($id);'>Eliminar</a></div>
                        <div class='celdas'><a href=\"productos_detalle.php?id=$id\">Ver detalle</a></div>
                        <div class='celdas'><a href=\"productos_edita.php?id=$id\">Editar</a></div>
                    </div>";
                }
            }
    echo "</div>
        <div id='mensaje'></div>";
    ?>
  </body>
</html>
