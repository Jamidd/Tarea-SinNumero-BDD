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
        $pid = $_SESSION["id"];
        $id_tienda = $_SESSION["id_tienda_compra"];
        $id_prod = $_POST["id_prod"];
        $cant = $_POST["cant"];
        $cuotas = $_POST["cuotas"];

        $pid = intval($pid);
        $id_tienda = intval($id_tienda);
        $id_prod = intval($id_prod);
        $cant = intval($cant);
        $cuotas = intval($cuotas);
        
        $query = "SELECT p.id_producto FROM producto AS p, rtiendaproducto AS r WHERE r.id_tienda = '$id_tienda' AND r.id_producto = p.id_producto";
        $result = $db -> prepare($query);
        $result -> execute();
        $productos = $result -> fetchAll();

        $encontrado = 0;
        foreach ($productos as $prod) {
            if ($prod[0] == $id_prod){
                $encontrado = 1;
            }
        }

        if ($encontrado == 1){
            $query = "SELECT precio FROM producto WHERE id_producto = '$id_prod'";
            $result = $db -> prepare($query);
            $result -> execute();
            $precio = $result -> fetchAll();
            $precio = $precio[0][0];

            echo "<div class=\"container space\">
                    <br><h5> Compra efectuada</h5><br>  
                    <a class=\"btn btn-warning\" href=\"compra.php\" role=\"button\">Atras</a>
                </div>";
            $query = "SELECT max(id_compra) FROM compraproducto";
            $result = $db -> prepare($query);
            $result -> execute();
            $id_compra = $result -> fetchAll();
            $id_compra_nuevo = intval($id_compra[0][0] +1);
            //echo "<div class=\"container space\">
                    //<br><h5>'$precio'</h5><br>  
                //</div>";

            $query = "INSERT INTO compraproducto VALUES ('$id_compra_nuevo', CURRENT_DATE, '$id_tienda', '$pid')";
            $result = $db -> prepare($query);
            $result -> execute();
            $a = $result -> fetchAll();

            $query = "INSERT INTO rcompraproducto VALUES ('$id_compra_nuevo', '$id_prod', '$cant')";
            $result = $db -> prepare($query);
            $result -> execute();
            $a = $result -> fetchAll();

            try {
                    $db = new PDO("pgsql:dbname=".DATABASE1.";host=".HOST1.";port=".PORT1.";user=".USER1.";password=".PASSWORD1);
                }
            catch(PDOException $e) {
                    echo $e->getMessage();
                }
            $tot = $precio * $cant;
            $query = "INSERT INTO pagos VALUES (DEFAULT, '$pid', '$id_tienda', '$tot', CURRENT_DATE)";
            $result = $db -> prepare($query);
            $result -> execute();
            $a = $result -> fetchAll();

            $query = "SELECT max(id_pagos) FROM pagos";
            $result = $db -> prepare($query);
            $result -> execute();
            $id_pago = $result -> fetchAll();
            $id_pago = intval($id_pago[0][0]);


            $tot_cuot = $tot / $cuotas;
            for ($i=0; $i < $cuotas; $i++) { 
                $query = "INSERT INTO cuotas VALUES (DEFAULT, '$id_pago', '$tot_cuot', CURRENT_DATE + interval '1 month', '0')";
                $result = $db -> prepare($query);
                $result -> execute();
                $a = $result -> fetchAll();
            }
        }else{
            echo "<div class=\"container space\">
                    <br><h5> ERROR: Compra no efectuada</h5><br>  
                    <a class=\"btn btn-warning\" href=\"compra.php\" role=\"button\">Atras</a>
                </div>";
        }

       


        
      ?>
  </div>
</body>
</html>