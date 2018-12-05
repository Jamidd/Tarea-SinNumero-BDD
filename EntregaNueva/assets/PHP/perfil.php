

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
            session_start();
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

</body>
</html>