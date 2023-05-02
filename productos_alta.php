<?php
    echo "<div class='link divIzq'><a href=\"productos_lista.php\">Regresar al listado</a></div><br><br>";
    echo "<div align='center' style='font-weight: bold; font-size: 40px;'>Alta de Productos</div><br>";
    echo "<HR noshade align='center' style='margin-bottom: 30;'>";
?>

<html>
 <head>
  <title>Alta de Productos</title>
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
                          $('#mensaje2').html('El codigo '+codigo+' ya existe').css("color", "red");
                          //esta linea borra el contenido del input del codigo
                          $('#codigo').val('');
                      } else {
                          $('#mensaje2').html('codigo apropiado').css("color", "green");
                      }
                      setTimeout("$('#mensaje2').html('')", 5000);
              },error: function() {
                  alert('Error archivo no encontrado...');
              }
          });
      }
    }

    $(document).on('change','input[type="file"]',function(){
      var fileName = this.files[0].name;
      var ext = fileName.split('.').pop();
      //convierte a minus
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
    }
    );
  </script>
  <style>
    .divIzq {
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

    input, textarea, select {
      width: 250px;
      margin:2px auto;
      box-sizing: border-box;
    }

    body{
      background-color: lightcyan;
      margin: 0;
      height: 100vh;
    }

    a {
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

    #mensaje2 {
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
 </head>
 <body>
	<form enctype="multipart/form-data" name="forma01" action="productos_salva.php" method="POST" align="center">
    <label for="nombre">Nombre</label>
		<input type="text" name="nombre" placeholder="Escribe tu nombre">
    <br>
		<label for="descripcion">Descripcion</label>
		<textarea id = "descripcion", name = 'descripcion', cols="40", rows="10"> </textarea>
    <br>
    <label for="codigo" style="margin: 2px 0px 0px 430px;">Codigo</label>
    <input onblur="validarCodigo();" name="codigo" id="codigo" placeholder="Escribe tu codigo">
    <div id='mensaje2' style="margin: 2px 180px 0px 0px;"></div>
    <br>
    <label for="costo">Costo</label>
    <input name="costo" placeholder="Escribe el costo">
    <br>
    <label for="stock">Stock</label>
    <input name="stock" placeholder="Escribe el stock">
    <br>
    <label for="foto">Foto</label>
    <input type="file" name="foto" accept="image/jpeg,image/jpg,image/png">
    <br>
		<input style="background-color: gray; width: 150px; margin: 10px auto;" onclick="return valida();" type="submit" value="Guardar">
	</form>
  <div id='mensaje'></div>
 </body>
</html>
