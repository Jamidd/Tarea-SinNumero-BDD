
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
    <div class="container space">
    <?php
        include_once "psql-config.php";
        try {
            $db = new PDO("pgsql:dbname=".DATABASE2.";host=".HOST2.";port=".PORT2.";user=".USER2.";password=".PASSWORD2);
            $db2 = new PDO("pgsql:dbname=".DATABASE1.";host=".HOST1.";port=".PORT1.";user=".USER1.";password=".PASSWORD1);
        }
        catch(PDOException $e) {
        echo $e->getMessage();
        }
        
        $type = $_GET['type'];
        $cid = $_GET['cid'];

        if (!$type){ // Servicio
            $amount = "SELECT SUM(s.precio)
            FROM servicio AS s, rcompraservicio AS rcs
            WHERE rcs.id_compraservicio = '$cid' AND rcs.id_servicio = s.id_servicio LIMIT 1;";
            $store = "SELECT ts.correo, cs.id_usuario, cs.fecha_de_compra FROM compraservicio AS cs, tiendadeservicio AS ts WHERE cs.id_compraservicio::int = '$cid' AND ts.id_tienda_s::bigint = cs.id_tienda_s::bigint;";
            $result1 = $db -> prepare($amount);
            $result1 -> execute();
            $nombres1 = $result1 -> fetchAll();
            foreach ($nombres1 as $persona1) {
                echo "<div class=\"container\"><h2 class=\"text-center\">Monto: $persona1[0]</h2></div>";
            }

            $resultk = $db -> prepare($store);
            $resultk -> execute();
            $nombresk = $resultk -> fetchAll();

            $store_mail = $nombresk[0][0];
            $user_id = $nombresk[0][1];
            $date = $nombresk[0][2];

            echo "<div class=\"container\"><h2 class=\"text-center\">Servicios</h2></div>";
            echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Nombre Producto</th><th class=\"querytext\" scope=\"col\">Precio</th><th class=\"querytext\" scope=\"col\">Descripción</th></tr></thead><tbody>";
            $servicios = "SELECT s.nombre, s.precio, s.descripcion FROM servicio AS s, rcompraservicio as rcs
            WHERE rcs.id_compraservicio::int = '$cid' AND rcs.id_servicio::bigint = s.id_servicio::bigint;";
            $result2 = $db -> prepare($servicios);
            $result2 -> execute();
            $nombres2 = $result2 -> fetchAll();
            foreach ($nombres2 as $persona2) {
                echo "<tr><td class=\"querytext\">$persona2[0]</td><td class=\"querytext\">$persona2[1]</td><td class=\"querytext\">
                $persona2[2]</td></tr>";
            }
            echo "</tbody></table>";

            if (!empty($store_mail)){
                echo "<div class=\"container\"><h2 class=\"text-center\">Cuotas</h2></div>";

                $cuotas = "SELECT cuo.monto, cuo.fecha_expiracion, cuo.pagado FROM usuario AS usr, cuotas AS cuo, pagos as pg
                WHERE pg.id_usuario1 = '$user_id' AND usr.id_usuario::bigint = pg.id_usuario2 AND usr.correo = '$store_mail' AND cuo.id_pagos::int = pg.id_pagos::int AND pg.fecha_transaccion = '$date'::date;";

                echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Monto</th><th class=\"querytext\" scope=\"col\">Fecha Expiración</th><th class=\"querytext\" scope=\"col\">Pagado</th></tr></thead><tbody>";

                $result3 = $db2 -> prepare($cuotas);
                $result3 -> execute();
                $nombres3 = $result3 -> fetchAll();

                foreach ($nombres3 as $persona3) {
                if ($persona3[2]){
                    $pag = 'SI';
                } else {
                    $pag = 'NO';
                }
                echo "<tr><td class=\"querytext\">$persona3[0]</td><td class=\"querytext\">$persona3[1]</td><td class=\"querytext\">
                $pag</td></tr>";
            }
            echo "</tbody></table>";
            }

            echo "<a class=\"btn btn-warning space\" href=\"compras_hist.php\" role=\"button\">Volver</a>";
        } else { // Producto
            $amount = "SELECT SUM(p.precio * rcp.cantidad) FROM producto AS p, rcompraproducto as rcp
            WHERE rcp.id_compra::int = '$cid' AND p.id_producto::int = rcp.id_producto::int LIMIT 1;";

            $store = "SELECT cp.id_usuario, cp.fecha, t.correo
            FROM compraproducto AS cp, tienda AS t WHERE t.id_tienda::int = cp.id_tienda::int AND cp.id_compra::bigint = '$cid';";

            $result1 = $db -> prepare($amount);
            $result1 -> execute();
            $nombres1 = $result1 -> fetchAll();

            foreach ($nombres1 as $persona1) {
            echo "<div class=\"container\"><h2 class=\"text-center\">Monto: $persona1[0]</h2></div>";
            }

            $resultk = $db -> prepare($store);
            $resultk -> execute();
            $nombresk = $resultk -> fetchAll();

            $store_mail = $nombresk[0][2];
            $user_id = $nombresk[0][0];
            $date = $nombresk[0][1];

            echo "<div class=\"container\"><h2 class=\"text-center\">Productos</h2></div>";
            echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">ID Producto</th><th class=\"querytext\" scope=\"col\">Nombre Producto</th><th class=\"querytext\" scope=\"col\">Precio Unitario</th><th class=\"querytext\" scope=\"col\">Cantidad</th><th class=\"querytext\" scope=\"col\">Precio Total</th></tr></thead><tbody>";
            $servicios = "SELECT rcp.id_producto, p.nombre, p.precio, rcp.cantidad FROM producto AS p, rcompraproducto AS rcp
            WHERE rcp.id_compra::int = '$cid' AND p.id_producto::bigint = rcp.id_producto::bigint;";
            $result2 = $db -> prepare($servicios);
            $result2 -> execute();
            $nombres2 = $result2 -> fetchAll();
            foreach ($nombres2 as $persona2) {
                $total = $persona2[2] * $persona2[3];
                echo "<tr><td class=\"querytext\">$persona2[0]</td><td class=\"querytext\">$persona2[1]</td><td class=\"querytext\">
                $persona2[2]</td><td class=\"querytext\">$persona2[3]</td><td class=\"querytext\">$total</td></tr>";
            }
            echo "</tbody></table>";

            if (!empty($store_mail)){
                echo "<div class=\"container\"><h2 class=\"text-center\">Cuotas</h2></div>";

                $cuotas = "SELECT cuo.monto, cuo.fecha_expiracion, cuo.pagado FROM usuario AS usr, cuotas AS cuo, pagos as pg
                WHERE pg.id_usuario1::int = '$user_id' AND usr.id_usuario::bigint = pg.id_usuario2 AND usr.correo = '$store_mail' AND cuo.id_pagos::int = pg.id_pagos::int AND pg.fecha_transaccion = '$date'::date;";

                echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Monto</th><th class=\"querytext\" scope=\"col\">Fecha Expiración</th><th class=\"querytext\" scope=\"col\">Pagado</th></tr></thead><tbody>";



                $result3 = $db2 -> prepare($cuotas);
                $result3 -> execute();
                $nombres3 = $result3 -> fetchAll();

                foreach ($nombres3 as $persona3) {
                if ($persona3[2]){
                    $pag = 'SI';
                } else {
                    $pag = 'NO';
                }
                echo "<tr><td class=\"querytext\">$persona3[0]</td><td class=\"querytext\">$persona3[1]</td><td class=\"querytext\">
                $pag</td></tr>";
            }
            echo "</tbody></table>";
            }

            echo "<a class=\"btn btn-warning space\" href=\"compras_hist.php\" role=\"button\">Volver</a>";
        }
      ?>
  </div>
</body>
</html>