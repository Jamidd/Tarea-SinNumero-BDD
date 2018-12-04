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
        <a class="btn btn-warning" href="productosyservicios.php" role="button">Atras</a>
    </div>
    <div class="container space">
        <?php 
            include_once "psql-config.php";
            try {
                $db = new PDO("pgsql:dbname=".DATABASE2.";host=".HOST2.";port=".PORT2.";user=".USER2.";password=".PASSWORD2);
             }
            catch(PDOException $e) {
            echo $e->getMessage();
            }
            $nombre = $_POST["pos"];


            $query1 = "SELECT * FROM producto 
            WHERE LOWER(producto.nombre) LIKE LOWER('%$nombre%');";

            $query2 = "SELECT * FROM servicio
            WHERE LOWER(servicio.nombre) LIKE LOWER('%$nombre%');";


            $result1 = $db -> prepare($query1);
            $result1 -> execute();
            $nombres1 = $result1 -> fetchAll();
            $result2 = $db -> prepare($query2);
            $result2 -> execute();
            $nombres2 = $result2 -> fetchAll();
            
            echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Id</th><th class=\"querytext\" scope=\"col\">Nombre</th><th class=\"querytext\" scope=\"col\">Precio</th><th class=\"querytext\" scope=\"col\">Descripcion</th><th class=\"querytext\" scope=\"col\">Tipo</th><th class=\"querytext\" scope=\"col\"></th></tr></thead><tbody>";
            foreach ($nombres1 as $producto) {
                echo "<tr><td class=\"querytext\">$producto[0]</td><td class=\"querytext\">$producto[1]</td><td class=\"querytext\">$producto[2]</td><td class=\"querytext\">$producto[3]</td><td class=\"querytext\"> Producto </td><td class=\"querytext\">
                <a class=\"btn btn-warning space\" href=\"detalles_prodser.php?tid=$producto[0]&type=0\" role=\"button\">Tiendas disponibles</a></td></tr>";
            }
            foreach ($nombres2 as $servicio) {
                echo "<tr><td class=\"querytext\">$servicio[0]</td><td class=\"querytext\">$servicio[1]</td><td class=\"querytext\">$servicio[2]</td><td class=\"querytext\">$servicio[3]</td><td class=\"querytext\"> Producto </td><td class=\"querytext\">
                <a class=\"btn btn-warning space\" href=\"detalles_prodser.php?tid=$servicio[0]&type=1\" role=\"button\">Tiendas disponibles</a></td></tr>";
            }
           
            echo "</tbody></table>";
        ?>
    </div>


</body>
</html>