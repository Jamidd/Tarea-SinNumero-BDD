<?php
    session_start();
    $uid = $_SESSION["id"];
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

            $vista1 = "CREATE VIEW PagosHechos AS
            SELECT usuario.id_usuario AS uid, SUM(cuotas.monto) AS Total
            FROM cuotas, pagos, usuario
            WHERE usuario.id_usuario::int = pagos.id_usuario1 AND cuotas.id_pagos = pagos.id_pagos AND cuotas.pagado::int = 0
            GROUP BY usuario.id_usuario;";

            $vista2 = "CREATE VIEW PagosRecibidos AS
            SELECT usuario.id_usuario AS uid, SUM(cuotas.monto) AS Total
            FROM cuotas, pagos, usuario
            WHERE usuario.id_usuario::int = pagos.id_usuario2 AND cuotas.id_pagos = pagos.id_pagos AND cuotas.pagado::int = 0
            GROUP BY usuario.id_usuario;";

            $vista3 = "CREATE VIEW Abonos AS
            SELECT usuario.id_usuario AS uid, SUM(abono.cantidad) AS Total
            FROM usuario, abono, tarjetasdecredito as tc
            WHERE usuario.id_usuario::bigint = tc.id_usuario::bigint AND tc.id_tarjeta::bigint = abono.id_tarjeta::bigint
            GROUP BY Usuario.id_usuario;";

            $query = "SELECT a.coalesce - b.coalesce + c.coalesce AS total 
            FROM (SELECT coalesce((SELECT total FROM abonos WHERE uid = '$uid'), 0)) AS a, 
            (SELECT coalesce((SELECT total FROM pagoshechos WHERE uid = '$uid'), 0)) AS b, 
            (SELECT coalesce((SELECT total FROM pagosrecibidos WHERE uid = '$uid'), 0)) AS c;";

            $v1 = $db -> prepare($vista1);
            $v2 = $db -> prepare($vista2);
            $v3 = $db -> prepare($vista3);

            $result = $db -> prepare($query);
            $v1 -> execute();
            $v2 -> execute();
            $v3 -> execute();
            $result -> execute();

            $nombres = $result -> fetchAll();
            echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Saldo</th></tr></thead><tbody>";
            foreach ($nombres as $persona) {
                echo "<tr><td class=\"querytext\">$persona[0]</td></tr>";
            }
            echo "</tbody></table>";
        ?>
    </div>
</body>
</html>