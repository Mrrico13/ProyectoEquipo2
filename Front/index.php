<html>
    <head>
        <title>Proyecto</title>
        
        <script src = "Librerias/jquery-3.3.1.min.js"></script>
        <script>
			function Agrega(id, codigo, cantidad, precio, actual)
			{
                var parametros = 
                {
                    "id_usuario" : id,
                    "codigo" : codigo,
                    "cantidad" : cantidad.value,
                    "precio" : precio,
                };
                $.ajax(
                {
                    url : 'StockActual.php',
                    type : 'post',
                    dataType : 'text',
                    data : parametros,

                    success : function(res)
                    {
                        if(res - cantidad.value < 0)
                        {
                            alert("La cantidad de productos solicitada excede el stock actual!");
                            
                        }
                        if(res - cantidad.value >= 0)
                        {
                            $.ajax(
                            {
                                url : 'Productos/AgregaProducto.php',
                                type : 'post',
                                dataType : 'text',
                                data : parametros,

                                success : function(res)
                                {
                                    if(res)
                                    {
                                        $.ajax(
                                        {
                                            url : 'EstadoCarrito.php',
                                            type : 'post',
                                            dataType : 'text',
                                            data : parametros,

                                            success : function(res)
                                            {
                                                if(res)
                                                {
                                                    
                                                    $('#textModify').html(res);
                                                }
                                            }
                                        });
                                        alert("Agregado al carrito con Exito");
                                    }

                                }
                            });
                        }
                    }
                });
                
			}
            function Detalle(id)
			{
				window.location.href = 'Productos/producto_detalle.php?id='+ id;
			}
        </script>

        <link rel="icon" href="Styles/icon.webp">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
		<link rel="stylesheet" href="Styles/style.css">

		
    </head>
    
    <body>
		<?php
			session_start();
            
			if (!isset($_SESSION['nombre']) || (trim($_SESSION['nombre']) == '')) 
			{
				header("location: Login.php");
				exit();
			}
            $id_usuario = $_SESSION['id'];
			
            function randomGen($min, $max, $quantity) {
                $numbers = range($min, $max);
                shuffle($numbers);
                return array_slice($numbers, 0, $quantity);
            }

            require "Funciones/conecta.php";
            $con = conecta();
			
            //PRODUCTOS
			$sql = "SELECT * FROM productos
					WHERE status = 1 AND eliminado = 0";

			$res = $con->query($sql);

            $max = mysqli_num_rows($res);

            $numbersList = randomGen(0,$max - 1,8);

            //BANNERS
            $sql = "SELECT * FROM banners
            WHERE status = 1 AND eliminado = 0";

            $banners = $con->query($sql);

            $max = mysqli_num_rows($banners);

            $Banner = rand(0, $max - 1)
		?>
		<div class = "MHead">
			<div class = "MHalf1", style = "padding-top: 35px;">
				<img class='normal' src='Styles/icon.webp', style = "height: auto; max-width: 50px; padding-left: 20px;">
				<div class = 'text', style = "padding-top: 10%; font-size: 26;"> 
				</div>
                <a class='link-wrapper', href ="index.php", style = "position: absolute; top: 30px; left: 22%;">
                    <span class='fallback'>Index</span>
                    <div class='img-wrapper'>
                        <img class='normal' src='Styles/FontResources/Buttons/InicioNormal.png'>

                </a>
                <a class='link-wrapper' href ="Productos/productos.php?pagina=1&", style = "position: absolute; top: 30px; left: 70%;">
                    <span class='fallback'>Index</span>
                    <div class='img-wrapper'>
                        <img class='normal' src='Styles/FontResources/Buttons/ProductosNormal.png'>

                </a>
                <a class='link-wrapper' href ="Contacto/contacto_formulario.php", style = "position: absolute; top: 30px; left: 130%;">
                    <span class='fallback'>Index</span>
                    <div class='img-wrapper'>
                        <img class='normal' src='Styles/FontResources/Buttons/ContactoNormal.png'>

                </a>
                <a class='link-wrapper' href ="Carrito/carrito_paso01.php", style = "position: absolute; top: 30px; left: 188%;">
                    <span class='fallback'>Index</span>
                    <div class='img-wrapper'>
                        <img class='normal' src='Styles/FontResources/Buttons/CarritoNormal.png'>

                </a>
                <div class = 'text', style = "position: absolute; top: 30px; left: 222%; font-size: 26; color: gold;">
					<?php
                        $sql1 = "SELECT * FROM pedidos WHERE id_usuario = $id_usuario AND estado = 0 ";

                        $num1 = $con->query($sql1);
                    
                        $count1 = $num1->fetch_array();

                        $id_pedido = 0;
                        foreach($num1 as $row)
                        {
                            if($row["id"] > 0)
                            {
                                $id_pedido = $row["id"];
                            }
                        }
                        $sql1 = "SELECT * FROM pedidos_productos
                        WHERE id_pedido = $id_pedido AND eliminado = 0";

                        $res1 = $con->query($sql1);

                        if($res1)
                        {
                            $count1 = mysqli_num_rows($res1);
                        }
                        else
                        {
                            $count1 = 0;
                        }
                        echo "<div id = 'textModify'> $count1 </div>";
                    ?>
                    <div id = 'textModify'> </div>
                </div>
                <a class='link-wrapper' href ="CerrarSesion.php", style = "position: absolute; top: 30px; left: 240%;">
                    <span class='fallback'>Index</span>
                    <div class='img-wrapper'>
                        <img class='normal' src='Styles/FontResources/Buttons/CerrarSesionNormal.png'>

                </a>
			</div>
		</div>
        <br><br>
        <div class = "MHead">
            <?php
                $i = 0;
                foreach($banners as $row)
                {
                    if($i == $Banner)
                    {
                        $archivo = $row["archivo"];
                    }
                    $i += 1;
                }
                echo"<img class='normal' src='../Proyecto2/Banners/imagenes/fotosBanners/".$archivo."', style = 'height: auto; max-width: 600px; padding-left: 35%; padding-top: 35%; z-index: -1;'>"
            ?>
            
		</div>
		<br><br>
		<div class = "MT", style = "position: absolute; top: 480px; padding-left: 5%; width: 750px; height: 3000px">
			<div class = "MF1">
				<div class = "MCA">
                <?php 
                        $i = 0;
                        foreach($res as $row)
                        {
                            if($i == $numbersList[6])
                            {
                                $id1 = $row["id"];
                                $codigo1 = $row["codigo"];
                                $stock = $row["stock"];
        
                                $archivo = $row["archivo"];
                                $nombre = $row["nombre"];
                                $costo1 = $row["costo"];
                            }
                            $i += 1;
                        }

                        echo '<img src = "../Proyecto2/Productos/imagenes/fotosProductos/'.$archivo.'", style="position:absolute; width:100px; height: 100px; top: 2%; left: 25%">';

                        echo '<a href="javascript:void(0);" onclick = "return Detalle('.$id1.')", style = "position: absolute; top: 55%; left: 13%; z-index: 1;">'.$nombre.'</a> ';
                        echo '<div class = "text",id = "'.$id1.'", style = "position:absolute; top: 70%; left: 40%"> '."$ ".$costo1.' </div>';
                        if($stock > 0)
                        {
                            echo"
                            <a class='link-wrapper' onclick = 'return Agrega($id_usuario, \"$codigo1\", select1, $costo1, $id1)', style = 'position: absolute; top: 90%; left: 0%;'>
                                <span class='fallback'>Index</span>
                                <div class='img-wrapper'>
                                    <img class='normal' src='Styles/FontResources/Buttons/ComprarNormal.png'>
                                    
                                </div>

                            </a>";
                            echo "<select name = 'mySelect', id = 'select1', style = 'position: absolute; top: 89%; left: 75%; z-index: 1;'";
                            echo '<option>' . 1 . '</option>';   
                            for($optionIndex = 1; $optionIndex <= $stock; $optionIndex++)
                            {
                                echo '<option>' . $optionIndex . '</option>';   
                            }
                        
                            echo "</select>";
                        }
                        else
                        {
                            echo '<div class = "text", style = "position:absolute; top: 85%; left: 20%; font-size: 30;"> Sin Stock </div>';
                        }
                    ?>
				</div>
				<div class = "MCA">
                    <?php 
                        $i = 0;
                        foreach($res as $row)
                        {
                            if($i == $numbersList[0])
                            {
                                $id2 = $row["id"];
                                $codigo2 = $row["codigo"];
                                $stock = $row["stock"];
        
                                $archivo = $row["archivo"];
                                $nombre = $row["nombre"];
                                $costo2 = $row["costo"];
                            }
                            $i += 1;
                        }

                        echo '<img src = "../Proyecto2/Productos/imagenes/fotosProductos/'.$archivo.'", style="position:absolute; width:100px; height: 100px; top: 2%; left: 25%">';

                        echo "<a href='javascript:void(0);' onclick = 'return Detalle($id2)', style = 'position: absolute; top: 55%; left: 13%; z-index: 1;'>$nombre</a> ";
                        echo '<div class = "text",id = '.$id2.', style = "position:absolute; top: 70%; left: 40%"> '."$ ".$costo2.' </div>';
                        
                        if($stock > 0)
                        {
                            echo"
                            <a class='link-wrapper' onclick = 'return Agrega($id_usuario, \"$codigo2\", select2, $costo2, $id2)', style = 'position: absolute; top: 90%; left: 0%;'>
                                <span class='fallback'>Index</span>
                                <div class='img-wrapper'>
                                    <img class='normal' src='Styles/FontResources/Buttons/ComprarNormal.png'>
                                    
                                </div>

                            </a>";
                            echo "<select name = 'mySelect', id = 'select2', style = 'position: absolute; top: 89%; left: 75%; z-index: 1;'";
                            echo '<option>' . 1 . '</option>';   
                            for($optionIndex = 1; $optionIndex <= $stock; $optionIndex++)
                            {
                                echo '<option>' . $optionIndex . '</option>';   
                            }
                        
                            echo "</select>";
                        }
                        else
                        {
                            echo '<div class = "text", style = "position:absolute; top: 85%; left: 20%; font-size: 30;"> Sin Stock </div>';
                        }
                    ?>
				</div>
				<div class = "MCA">
                <?php 
                        $i = 0;
                        foreach($res as $row)
                        {
                            if($i == $numbersList[1])
                            {
                                $id3 = $row["id"];
                                $codigo3 = $row["codigo"];
                                $stock = $row["stock"];
        
                                $archivo = $row["archivo"];
                                $nombre = $row["nombre"];
                                $costo3 = $row["costo"];
                            }
                            $i += 1;
                        }

                        echo '<img src = "../Proyecto2/Productos/imagenes/fotosProductos/'.$archivo.'", style="position:absolute; width:100px; height: 100px; top: 2%; left: 25%">';

                        echo "<a href='javascript:void(0);' onclick = 'return Detalle($id3)', style = 'position: absolute; top: 55%; left: 13%; z-index: 1;'>$nombre</a> ";
                        echo '<div class = "text",id = '.$id3.', style = "position:absolute; top: 70%; left: 40%"> '."$ ".$costo3.' </div>';
                        
                        if($stock > 0)
                        {
                            echo"
                            <a class='link-wrapper' onclick = 'return Agrega($id_usuario, \"$codigo3\", select3, $costo3, $id3)', style = 'position: absolute; top: 90%; left: 0%;'>
                                <span class='fallback'>Index</span>
                                <div class='img-wrapper'>
                                    <img class='normal' src='Styles/FontResources/Buttons/ComprarNormal.png'>
                                    
                                </div>

                            </a>";
                            echo "<select name = 'mySelect', id = 'select3', style = 'position: absolute; top: 89%; left: 75%; z-index: 1;'";
                            echo '<option>' . 1 . '</option>';   
                            for($optionIndex = 1; $optionIndex <= $stock; $optionIndex++)
                            {
                                echo '<option>' . $optionIndex . '</option>';   
                            }
                        
                            echo "</select>";
                        }
                        else
                        {
                            echo '<div class = "text", style = "position:absolute; top: 85%; left: 20%; font-size: 30;"> Sin Stock </div>';
                        }
                    ?>
				</div>
                <div class = "MCA">
                <?php 
                        $i = 0;
                        foreach($res as $row)
                        {
                            if($i == $numbersList[2])
                            {
                                $id4 = $row["id"];
                                $codigo4 = $row["codigo"];
                                $stock = $row["stock"];
        
                                $archivo = $row["archivo"];
                                $nombre = $row["nombre"];
                                $costo4 = $row["costo"];
                            }
                            $i += 1;
                        }

                        echo '<img src = "../Proyecto2/Productos/imagenes/fotosProductos/'.$archivo.'", style="position:absolute; width:100px; height: 100px; top: 2%; left: 25%">';

                        echo "<a href='javascript:void(0);' onclick = 'return Detalle($id4)', style = 'position: absolute; top: 55%; left: 13%; z-index: 1;'>$nombre</a> ";
                        echo '<div class = "text",id = '.$id4.', style = "color: white; position:absolute; top: 70%; left: 40%"> '."$ ".$costo4.' </div>';
                        
                        if($stock > 0)
                        {
                            echo"
                            <a class='link-wrapper' onclick = 'return Agrega($id_usuario, \"$codigo4\", select4, $costo4, $id4)', style = 'position: absolute; top: 90%; left: 0%;'>
                                <span class='fallback'>Index</span>
                                <div class='img-wrapper'>
                                    <img class='normal' src='Styles/FontResources/Buttons/ComprarNormal.png'>
                                    
                                </div>

                            </a>";
                            echo "<select name = 'mySelect', id = 'select4', style = 'position: absolute; top: 89%; left: 75%; z-index: 1;'";
                            echo '<option>' . 1 . '</option>';   
                            for($optionIndex = 1; $optionIndex <= $stock; $optionIndex++)
                            {
                                echo '<option>' . $optionIndex . '</option>';   
                            }
                        
                            echo "</select>";
                        }
                        else
                        {
                            echo '<div class = "text", style = "position:absolute; top: 85%; left: 20%; font-size: 30;"> Sin Stock </div>';
                        }
                    ?>
				</div>
                <div class = "MCA">
                <?php 
                        $i = 0;
                        foreach($res as $row)
                        {
                            if($i == $numbersList[3])
                            {
                                $id5 = $row["id"];
                                $codigo5 = $row["codigo"];
                                $stock = $row["stock"];
        
                                $archivo = $row["archivo"];
                                $nombre = $row["nombre"];
                                $costo5 = $row["costo"];
                            }
                            $i += 1;
                        }

                        echo '<img src = "../Proyecto2/Productos/imagenes/fotosProductos/'.$archivo.'", style="position:absolute; width:100px; height: 100px; top: 2%; left: 25%">';

                        echo "<a href='javascript:void(0);' onclick = 'return Detalle($id5)', style = 'position: absolute; top: 55%; left: 13%; z-index: 1;'>$nombre</a> ";
                        echo '<div class = "text",id = '.$id5.', style = "color: white; position:absolute; top: 70%; left: 40%"> '."$ ".$costo5.' </div>';
                        
                        if($stock > 0)
                        {
                            echo"
                            <a class='link-wrapper' onclick = 'return Agrega($id_usuario, \"$codigo5\", select5, $costo5, $id5)', style = 'position: absolute; top: 90%; left: 0%;'>
                                <span class='fallback'>Index</span>
                                <div class='img-wrapper'>
                                    <img class='normal' src='Styles/FontResources/Buttons/ComprarNormal.png'>
                                    
                                </div>

                            </a>";
                            echo "<select name = 'mySelect', id = 'select5', style = 'position: absolute; top: 89%; left: 75%; z-index: 1;'";
                            echo '<option>' . 1 . '</option>';   
                            for($optionIndex = 1; $optionIndex <= $stock; $optionIndex++)
                            {
                                echo '<option>' . $optionIndex . '</option>';   
                            }
                        
                            echo "</select>";
                        }
                        else
                        {
                            echo '<div class = "text", style = "position:absolute; top: 85%; left: 20%; font-size: 30;"> Sin Stock </div>';
                        }
                    ?>
				</div>
				<div class = "MCA">
                <?php 
                        $i = 0;
                        foreach($res as $row)
                        {
                            if($i == $numbersList[4])
                            {
                                $id6 = $row["id"];
                                $codigo6 = $row["codigo"];
                                $stock = $row["stock"];
        
                                $archivo = $row["archivo"];
                                $nombre = $row["nombre"];
                                $costo6 = $row["costo"];
                            }
                            $i += 1;
                        }

                        echo '<img src = "../Proyecto2/Productos/imagenes/fotosProductos/'.$archivo.'", style="position:absolute; width:100px; height: 100px; top: 2%; left: 25%">';

                        echo "<a href='javascript:void(0);' onclick = 'return Detalle($id6)', style = 'position: absolute; top: 55%; left: 13%; z-index: 1;'>$nombre</a> ";
                        echo '<div class = "text",id = '.$id6.', style = " color: white; position:absolute; top: 70%; left: 40%"> '."$ ".$costo6.' </div>';
                        
                        if($stock > 0)
                        {
                            echo"
                            <a class='link-wrapper' onclick = 'return Agrega($id_usuario, \"$codigo6\", select6, $costo6, $id6)', style = 'position: absolute; top: 90%; left: 0%;'>
                                <span class='fallback'>Index</span>
                                <div class='img-wrapper'>
                                    <img class='normal' src='Styles/FontResources/Buttons/ComprarNormal.png'>
                                </div>

                            </a>";
                            echo "<select name = 'mySelect', id = 'select6', style = 'position: absolute; top: 89%; left: 75%; z-index: 1;'";
                            echo '<option>' . 1 . '</option>';   
                            for($optionIndex = 1; $optionIndex <= $stock; $optionIndex++)
                            {
                                echo '<option>' . $optionIndex . '</option>';   
                            }
                        
                            echo "</select>";
                        }
                        else
                        {
                            echo '<div class = "text", style = "position:absolute; top: 85%; left: 20%; font-size: 30;"> Sin Stock </div>';
                        }
                    ?>
				</div>
				
			</div>
		</div>
        <div class = MF2, style = "position: absolute; padding-top: 850px; padding-left: 5%; width: 100%">
				<div class = 'text'> 
                    Proyecto   ||  Terminos y condiciones	  || Leo Castellanos® ||  Todos los derechos reservados					
				</div>
			</div>
    </body>    
<html>