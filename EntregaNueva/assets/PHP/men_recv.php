<?php
    include_once "funciones.php";
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
                echo '<a class="btn btn-primary" href="mensajeria.php" role="button">Mensajeria</a>';
                echo '<a class="btn btn-primary" href="abonosyseguros.php" role="button">Abonos y Seguros</a>';
                echo '<a class="btn btn-primary" href="transeferencias.php" role="button">Hacer transferencia</a>';
                echo '<a class="btn btn-primary" href="compra.php" role="button">Compra</a>';
            };
        ?>
        <a class="btn btn-primary" href="busquedatiendas.php" role="button">Búsqueda de tiendas</a>
        <a class="btn btn-primary" href="productosyservicios.php" role="button">Productos y Servicios</a>
        <a class="btn btn-primary" href="logout_handler.php" role="button">Logout</a>
    </div>
<br>

<?php
    $id = $_SESSION['id'];
    $request = GetUser($id);
    $info = json_decode($request, true);
    echo "<table class=\"table querytable\"><thead><tr>
    <th class=\"querytext\" scope=\"col\">Emisor</th>
    <th class=\"querytext\" scope=\"col\">Mensaje</th>
    <th class=\"querytext\" scope=\"col\">Fecha</th>
    </tr></thead><tbody>";
    
    foreach ($info["messages"] as $mensaje) {
        if ($mensaje["receptant"] == $id){
            $a = $mensaje["sender"];
            $b = $mensaje["message"];
            $c = $mensaje["date"];
            echo "<tr>
            <td class=\"querytext\">$a</td>
            <td class=\"querytext\">$b</td>
            <td class=\"querytext\">$c</td>
            </tr>";
            echo $mensaje["message"];
            echo "\n";
        }
    }
?>


</body>
</html>
