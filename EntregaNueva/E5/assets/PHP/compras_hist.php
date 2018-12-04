
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
        <a class="btn btn-primary" href="trans_hist.php" role="button">Ver transferencias historicas</a>
        <a class="btn btn-primary" href="compras_hist.php" role="button">Ver compras</a>
        <a class="btn btn-primary" href="lista_targetas.php" role="button">Lista Tarjetas</a>
        <a class="btn btn-primary" href="lista_seguros.php" role="button">Lista Seguros</a>
        <a class="btn btn-primary" href="saldo.php" role="button">Saldo</a>
    </div>
<!--<br>
<a id="a0" href="html_images.asp" target="_blank">Ver transferencias historicas</a> 
<br>
<a id="a0" href="html_images.asp" target="_blank">Lista de compras</a> 
<br>
<a id="a0" href="html_images.asp" target="_blank">Lista de tarjetas y seguros</a> 
<br>-->
    <div class="container space">
    <?php
        include_once "psql-config.php";
        try {
            $db = new PDO("pgsql:dbname=".DATABASE2.";host=".HOST2.";port=".PORT2.";user=".USER2.";password=".PASSWORD2);
          }
          catch(PDOException $e) {
          echo $e->getMessage();
          }
        $pid = $_SESSION["id"];
        echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Tienda</th><th class=\"querytext\" scope=\"col\">Fecha</th><th class=\"querytext\" scope=\"col\"></th></tr></thead><tbody>";
        $amount = "SELECT cs.id_compraservicio, ts.nombre, cs.fecha_de_compra
        FROM compraservicio AS cs, tiendadeservicio AS ts WHERE cs.id_usuario::int = '$pid' AND cs.id_tienda_s::bigint = ts.id_tienda_s::bigint;";
        $result1 = $db -> prepare($amount);
        $result1 -> execute();
        $nombres1 = $result1 -> fetchAll();
        foreach ($nombres1 as $persona1) {
            echo "<tr><td class=\"querytext\">$persona1[1]</td><td class=\"querytext\">$persona1[2]</td><td class=\"querytext\">
            <a class=\"btn btn-warning space\" href=\"detalles_compra.php?cid=$persona1[0]&type=0\" role=\"button\">Detalles</a></td></tr>";
        }
        $amount2 = "SELECT cs.id_compra, tienda.nombre, cs.fecha
        FROM compraproducto AS cs, tienda WHERE cs.id_usuario::int = '$pid' AND cs.id_tienda::bigint = tienda.id_tienda::bigint;";
        $result2 = $db -> prepare($amount2);
        $result2 -> execute();
        $nombres2 = $result2 -> fetchAll();
        foreach ($nombres2 as $persona2) {
            echo "<tr><td class=\"querytext\">$persona2[1]</td><td class=\"querytext\">$persona2[2]</td><td class=\"querytext\">
            <a class=\"btn btn-warning space\" href=\"detalles_compra.php?cid=$persona2[0]&type=1\" role=\"button\">Detalles</a></td></tr>";
        }
        echo "</tbody></table>";
      ?>
  </div>
</body>
</html>
