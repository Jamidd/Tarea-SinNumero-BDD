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
        $pid = $_SESSION["id"];
        $id_tar = $_POST["tid"];
        $pid = intval($pid);
        $id_tar = intval($id_tar);
        $query = "SELECT id_tarjeta
        FROM tarjetasdecredito WHERE id_tarjeta::bigint = '$id_tar'";

        $result = $db -> prepare($query);
        $result -> execute();
        # Ojo, fetch() nos retorna la primer fila, fetchAll()
        # retorna todas.
        $tarjetas = $result -> fetchAll(); 
        //echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Monto</th></tr></thead><tbody>"
        $listo = 0;
        if (!count($tarjetas)){
            echo "<p>Tarjeta no eliminada</p>";
        } else {
            $query = "DELETE FROM tarjetasdecredito WHERE id_tarjeta::bigint = '$id_tar'";
            $result = $db -> prepare($query);
            $result -> execute();
            echo "<p>Tarjeta eliminada</p>";
        }
      ?>
  </div>
</body>
</html>