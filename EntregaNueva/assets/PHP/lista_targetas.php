<?php
    session_start();
    $id = $_SESSION["id"];
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
        <a class="btn btn-primary" href="trans_hist.php" role="button">Ver transferencias historicas</a>
        <a class="btn btn-primary" href="compras_hist.php" role="button">Ver compras</a>
        <a class="btn btn-primary" href="lista_targetas.php" role="button">Lista Tarjetas</a>
        <a class="btn btn-primary" href="lista_seguros.php" role="button">Lista Seguros</a>
        <a class="btn btn-primary" href="saldo.php" role="button">Saldo</a>
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

            $query1 = "SELECT * FROM tarjetasdecredito WHERE id_usuario::int = '$id';";


            $result1 = $db -> prepare($query1);
            $result1 -> execute();
            $nombres1 = $result1 -> fetchAll();

            echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">ID Tarjeta</th><th class=\"querytext\" scope=\"col\">CVV</th><th class=\"querytext\" scope=\"col\">Fecha Expiración</th></tr></thead><tbody>";
            foreach ($nombres1 as $persona1) {
                echo "<tr><td class=\"querytext\">$persona1[1]</td><td class=\"querytext\">$persona1[2]</td><td class=\"querytext\">$persona1[3]</td></tr>";
            }
            echo "</tbody></table>";
        ?>
    </div>
</body>
</html>