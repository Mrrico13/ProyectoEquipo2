## cerrar sesion file 
<?php
    session_start();
    session_destroy();
    header("Location: ../index.php");
?>


##comprobar sesion file

<?php
    session_start();
    if(!isset($_SESSION['correo'])) {
        header("Location: index.php");
        session_destroy();
        die();
    }
?>

##conecta file

<?php
    define("HOST", 'localhost');
    define("BD", 'cliente01');
    define("USER_BD", 'root');
    define("PASS_BD", '');

    function conecta() {
        $con = new mysqli(HOST, USER_BD, PASS_BD, BD);
        return $con;
    }
?>

##menu file

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <style>
      *{
        padding: 0;
        margin: 0;
        text-decoration: none;
        list-style: none;
        box-sizing: border-box;
      }

      nav{
        background: #2fcdcd;
        height: 80px;
        width: 100%;
      }
      .enlace{
        position: absolute;
        padding: 20px 50px;
      }
      .logo{
        height: 40px;
      }
      nav ul{
        float: right;
        margin-right: 20px;
      }
      nav ul li{
        display: inline-block;
        line-height: 80px;
        margin: 0 5px;
      }
      nav ul li a{
        color: #fff;
        font-size: 18px;
        padding: 7px 13px;
        border-radius: 3px;
        text-transform: uppercase;
      }
      li a.active, li a:hover{
        background: #000090;
        transition: .5s;
      }
      .checkbtn{
        font-size: 30px;
        color: #fff;
        float: right;
        line-height: 80px;
        margin-right: 40px;
        cursor: pointer;
        display: none;
      }
      #check{
        display: none;
      }
      section{
        background: url(fondo.jpg) no-repeat;
        background-size: cover;
        background-position: center center;
        height: calc(100vh - 80px);
      }

      @media (max-width: 952px){
        .enlace{
            padding-left: 20px;
        }
        nav ul li a{
            font-size: 16px;
        }
      }

      @media (max-width: 858px){
        .checkbtn{
            display: block;
        }
        ul{
            position: fixed;
            width: 100%;
            height: 100vh;
            background: #2c3e50;
            top: 80px;
            left: -100%;
            text-align: center;
            transition: all .5s;
        }
        nav ul li{
            display: block;
            margin: 50px 0;
            line-height: 30px;
        }
        nav ul li a{
            font-size: 20px;
        }
        li a:hover, li a.active{
            background: none;
            color: red;
        }
        #check:checked ~ ul{
            left:0;
        }
      }
    </style>
</head>
<body>
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <a href="#" class="enlace">
            <img src="https://www.dwgautocad.com/uploads/8/3/4/5/8345765/logo-udg-png-blanco-y-negro_orig.png" alt="" class="logo">
        </a>
        <ul>
            <li>Bienvenido <?php $nombre = $_SESSION['nombre']; echo "$nombre" ?></li>
            <li><a class="active" href="bienvenido.php">Inicio</a></li>
            <li><a href="Admin/administradores_lista.php">Administradores</a></li>
            <li><a href="Productos/productos_lista.php">Productos</a></li>
            <li><a href="Banners/banners_lista.php">Banners</a></li>
            <li><a href="Pedidos/pedidos_lista.php">Pedidos</a></li>
            <li><a href="funciones/cerrarSesion.php">Cerrar sesión</a></li>
        </ul>
    </nav>
    <section></section>
</body>
</html>

##valida usuario file

<?php 
    session_start();
    require "conecta.php";
    $con = conecta();
    $correo = $_REQUEST['user'];
    $password = $_REQUEST['pass'];
    $passEnc = md5($password);
    $sql = "SELECT * FROM administradores WHERE correo = '$correo' AND pass = '$passEnc' AND status = 1 AND eliminado = 0";
    $res = $con->query($sql);
    $num = $res->num_rows;

    $row = $res->fetch_array();
    
    if($num>0) {
        $idU = $row["id"];
        $nombre = $row["nombre"].' '.$row["apellidos"];
        $correo = $row["correo"];

        $_SESSION['idU'] = $idU;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['correo'] = $correo;
        
       $bandera = 1;
    } else {
        $bandera = 0;
    }

    echo $bandera;
?>
