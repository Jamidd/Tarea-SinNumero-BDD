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
            $db = new PDO("pgsql:dbname=".DATABASE2.";host=".HOST2.";port=".PORT2.";user=".USER2.";password=".PASSWORD2);
        }
        catch(PDOException $e) {
        echo $e->getMessage();
        }
        
        $type = $_GET['type'];
        $tid = $_GET['tid'];

        if (!$type){ // Producto
            $query1 = "SELECT p.nombre FROM  rtiendaproducto as rtp, producto as p
            WHERE rtp.id_tienda = '$tid' and rtp.id_producto = p.id_producto ;";
            $result1 = $db -> prepare($query1);
            $result1 -> execute();
            $nombres1 = $result1 -> fetchAll();
            echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Nombre</th></tr></thead><tbody>";
            foreach ($nombres1 as $producto) {
                echo "<tr><td class=\"querytext\">$producto[0]</td></tr>";
            }
            echo "</tbody></table>";

            echo "<a class=\"btn btn-warning space\" href=\"busquedatiendas.php\" role=\"button\">Volver</a>";
            
        }// Servicio
        else { 
            $query2 = "SELECT s.nombre FROM  rtiendaservicio as rts, servicio as s
            WHERE rts.id_tienda_s = '$tid' and rts.id_servicio = s.id_servicio ;";
            $result2 = $db -> prepare($query2);
            $result2 -> execute();
            $nombres2 = $result2 -> fetchAll();
            echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Nombre</th></tr></thead><tbody>";
            foreach ($nombres2 as $servicio) {
                echo "<tr><td class=\"querytext\">$servicio[0]</td></tr>";
            }
            echo "</tbody></table>";

            echo "<a class=\"btn btn-warning space\" href=\"busquedatiendas.php\" role=\"button\">Volver</a>";
        }
      ?>
  </div>
</body>
</html>