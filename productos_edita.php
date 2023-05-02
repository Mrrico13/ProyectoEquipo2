<?php
    echo "<div class='link divIzq'><a href=\"productos_lista.php\">Regresar al listado</a></div><br><br>";
    echo "<div align='center' style='font-weight: bold; font-size: 40px;'>Edición de productos</div><br>";
    echo "<HR noshade align='center' style='margin-bottom: 30;'>";

    require "funciones/conecta.php";
    $con = conecta();

    $id = $_REQUEST['id'];

    $sql = "SELECT * FROM productos WHERE id = $id";

    $res = $con->query($sql);

    $row = $res->fetch_array();
    $nombre = $row["nombre"];
    $descripcion = $row["descripcion"];
    $codigo = $row["codigo"];
    $stock = $row["stock"];
    $costo = $row["costo"];
?>

<html>
 <head>
  <title>Edición de productos</title>
  <style>
    .divIzq{
        margin: 2% 0px 0px 5%;
    }

    label{
      display: inline-block;
      width: 80px;
    }

    .clasecodigo{
      float: left;
      position: relative;
      width: 80px;
    }

    input, textarea, select{
      width: 250px;
      margin:2px auto;
      box-sizing: border-box;
    }

    body{
      background-size: cover;
      background-repeat: no-repeat;
      margin: 0;
      height: 100vh;
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

    #mensajeVal{
        height:20px;
        line-height:20px;
        border: 2px solid black;
        background: lightskyblue;
        color: #F00;
        font-size: 16px;
        font-weight: bold;
        width: 250px;
        text-align: center;
        margin:2px auto;
    }

    #mensajecodigo{
      height:20px;
      line-height:22px;
      color: #F00;
      font-size: 15px;
      font-weight: bold;
      width: 250px;
      text-align: center;
      float: right;
      position: relative;
    }
  </style>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script>
    $(document).ready(function() {
        $("form").keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
        });
    });

    function valida() {
      var nombre = document.forma01.nombre.value;
      var descripcion = document.forma01.descripcion.value;
      var codigo = document.forma01.codigo.value;
      var costo = document.forma01.costo.value;
      var stock = document.forma01.stock.value;
      var foto = document.forma01.foto.value;

      if((nombre == "") || (descripcion == "") || (codigo == "") || (costo == "") || (stock == "") || (foto == "")) {
        $('#mensaje').html('Faltan campos por llenar');
        setTimeout("$('#mensaje').html('')",5000);
        return false;
      }
      return true;
    }

    function validarCodigo() {
      var codigo = $('#codigo').val();
      if(codigo) {
          $.ajax ({
                  url     : 'funciones/validarCodigo.php',
                  type    : 'post',
                  datatype : 'text',
                  data    : 'codigo='+codigo,
                  success : function(res) {
                      if (res == 1) {
                          $('#mensajecodigo').html('El codigo '+codigo+' ya existe').css("color", "red");
                          $('#codigo').val('');
                      } else {
                          $('#mensajecodigo').html('codigo apropiado').css("color", "green");
                      }
                      setTimeout("$('#mensajecodigo').html('')", 5000);
              },error: function() {
                  alert('Error archivo no encontrado...');
              }
          });
      }
    }

    $(document).on('change','input[type="file"]',function(){
      var fileName = this.files[0].name;
      var ext = fileName.split('.').pop();
      //minus
      ext = ext.toLowerCase();
      switch (ext) {
        case 'jpg':
        case 'jpeg':
        case 'png': break;
        default:
          alert('El archivo no tiene la extensión adecuada');
          this.value = '';
          this.files[0].name = '';
      }
    });
  </script>
 </head>
 <body>
<form enctype="multipart/form-data" name="forma01" action="productos_salvaEditar.php" method="POST" align="center">
    <label for="nombre">Nombre</label>
		<input type="text" name="nombre" placeholder="Escribe tu nombre" value=<?php echo $nombre ?>>
    <br>
		<label for="descripcion">Descripcion</label>
		<textarea id = "descripcion", name = 'descripcion', cols="40", rows="10"><?php echo "$descripcion" ?></textarea>
    <br>
    <label for="codigo" style="margin: 2px 0px 0px 0px;">Codigo</label>
    <input onblur="validarCodigo();" name="codigo" id="codigo" placeholder="Escribe tu codigo" value=<?php echo $codigo ?>>
    <div id='mensaje2' style="margin: 2px 180px 0px 0px;"></div>
    <br>
    <label for="costo">Costo</label>
    <input name="costo" placeholder="Escribe el costo" value=<?php echo $costo ?>>
    <br>
    <label for="stock">Stock</label>
    <input name="stock" placeholder="Escribe el stock" value=<?php echo $stock ?>>
    <br>
    <label for="foto">Foto</label>
    <input type="file" name="foto" accept="image/jpeg,image/jpg,image/png">
    <br>
		<input style="background-color: gray; width: 150px; margin: 10px auto;" onclick="return valida();" type="submit" value="Guardar">
	</form>
  <div id='mensajeVal'></div>
 </body>
</html>
