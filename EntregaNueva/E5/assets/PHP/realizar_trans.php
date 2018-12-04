<?php
    session_start();
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel="icon" href="https://vignette4.wikia.nocookie.net/mariokart/images/1/17/CoinMK8.png">
        <title>Banco Kawas</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
<body>
    <div class="container space">
        <a class="btn btn-primary" href="../../index.php" role="button">Inicio</a>
        <?php 
            if (isset($_SESSION['id'])){
                echo '<a class="btn btn-primary" href="perfil.php" role="button">Perfil</a>';
                echo '<a class="btn btn-primary" href="abonosyseguros.php" role="button">Abonos y Seguros</a>';
                echo '<a class="btn btn-primary" href="transeferencias.php" role="button">Hacer transferencia</a>';
                echo '<a class="btn btn-primary" href="compra.php" role="button">Compra</a>';
            };
        ?>
        <a class="btn btn-primary" href="busquedatiendas.php" role="button">Búsqueda de tiendas</a>
        <a class="btn btn-primary" href="productosyservicios.php" role="button">Productos y Servicios</a>
        <a class="btn btn-primary" href="logout_handler.php" role="button">Logout</a>
    </div>
    <div class="container space">
        <?php 
            include_once "psql-config.php";
            try {
                $db = new PDO("pgsql:dbname=".DATABASE1.";host=".HOST1.";port=".PORT1.";user=".USER1.";password=".PASSWORD1);
             }
            catch(PDOException $e) {
            echo $e->getMessage();
            }
            $id = intval($_SESSION["id"]);
            $nombre = '%'.$_POST["nombre"].'%';
            $apellido = '%'.$_POST["apellido"].'%';
            $monto = intval($_POST["monto"]);

            $query3 = "SELECT id_usuario FROM usuario WHERE LOWER(nombre) LIKE LOWER('$nombre') AND LOWER(apellido) LIKE LOWER('$apellido');";
            $result3 = $db -> prepare($query3);
            $result3 -> execute();
            $usuario = $result3 -> fetchAll();

            if (!count($usuario)){
                echo '<h2>El usuario no existe.</h2>';
            } else {
                $id2 = intval($usuario[0][0]);
                $query = "INSERT INTO pagos Values (DEFAULT, $id, $id2, $monto, CURRENT_DATE);";
                $result = $db -> prepare($query);
                $result -> execute();
                echo '<h2>Transferencia realizada exitosamente.</h2>';
            }
        ?>
</body>
</html>








