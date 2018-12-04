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
        <a class="btn btn-warning" href="anadir_quitar_tarjeta.php" role="button">Atras</a>
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
        $pid = intval($_SESSION["id"]);

        $csv = rand(100, 999);
        $ok = 0;
        while ($ok == 0) {
            $tar_id = rand(1000000000000, 9999999999999);
            $query = "SELECT id_tarjeta FROM tarjetasdecredito WHERE id_tarjeta = '$tar_id'";
            $result = $db -> prepare($query);
            $result -> execute();
            $tar = $result -> fetchAll();
            if (count($tar) == 0){
                $ok =1;
            }
            # code...
        }

        echo "<h3>Nueva Tarjeta Creada.</h3>";
        $query = "INSERT INTO tarjetasdecredito VALUES ('$pid', '$tar_id', '$csv', CURRENT_DATE + interval '4 year')";

        $result = $db -> prepare($query);
        $result -> execute();
        //echo "</tbody></table>";
      ?>
  </div>
</body>
</html>