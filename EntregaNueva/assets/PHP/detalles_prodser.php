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
            $pid = intval($_GET['tid']);
            $type = intval($_GET['type']);

            if ($type){ //Servicio
                $query = "SELECT ts.id_tienda_s, ts.nombre FROM tiendadeservicio as ts, rtiendaservicio as rts
                WHERE rts.id_servicio::int = '$pid' AND ts.id_tienda_s::int = rts.id_tienda_s::int;";
            } else { //Producto
                $query = "SELECT ts.id_tienda_s, ts.nombre FROM tienda as t, rtiendaproducto as rtp
                WHERE rtp.id_producto::int = '$pid' AND t.id_tienda::int = rtp.id_tienda::int;";
            };


            $result = $db -> prepare($query);
            $result -> execute();
            $nombres = $result -> fetchAll();
            
            echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Id</th><th class=\"querytext\" scope=\"col\">Nombre</th></tr></thead><tbody>";
            foreach ($nombres as $producto) {
                echo "<tr><td class=\"querytext\">$producto[0]</td><td class=\"querytext\">$producto[1]</td></tr>";
            }
            echo "</tbody></table>";
        ?>
    </div>


</body>
</html>