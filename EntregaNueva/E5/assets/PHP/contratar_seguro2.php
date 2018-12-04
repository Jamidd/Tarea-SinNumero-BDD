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
        <a class="btn btn-warning" href="abonosyseguros.php" role="button">Atras</a>
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
        $id_seguro = $_POST["nombre"];
        $pid = intval($pid);
        $id_seguro = intval($id_seguro);
        $query = "SELECT id_seguro
        FROM seguro";

        $result = $db -> prepare($query);
        $result -> execute();
        # Ojo, fetch() nos retorna la primer fila, fetchAll()
        # retorna todas.
        $seguros = $result -> fetchAll(); 
        //echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Monto</th></tr></thead><tbody>"
        $listo = 0;
        foreach ($seguros as $seg) {
            if ($seg[0] == $id_seguro){
                echo "<p>Seguro adquirido</p>";
                $query = "INSERT INTO rusuarioseguro VALUES ('$pid', '$id_seguro', CURRENT_DATE, CURRENT_DATE + interval '1 year')";
                $result = $db -> prepare($query);
                $result -> execute();
                $listo = 1;
            }   
            //echo "<tr><td class=\"querytext\">$persona[0]</td></tr>";
        };
        if ($listo == 0){
            echo "<p>Seguro no adquirido</p>";
        }
        //echo "</tbody></table>";
      ?>
  </div>
</body>
</html>
