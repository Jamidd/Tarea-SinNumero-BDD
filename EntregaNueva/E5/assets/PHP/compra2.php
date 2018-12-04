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
        $id_tienda = $_POST["id_tienda"];
        $_SESSION["id_tienda_compra"] = $id_tienda;
        $tiendaorserv = 0;

        $pid = intval($pid);
        $id_tienda = intval($id_tienda);
       
        $query = "SELECT id_tienda FROM tienda";
        $result = $db -> prepare($query);
        $result -> execute();
        # Ojo, fetch() nos retorna la primer fila, fetchAll()
        # retorna todas.
        $tiendas = $result -> fetchAll(); 
        
        foreach ($tiendas as $tien) {
            if ($tien[0] == $id_tienda){
                $tiendaorserv = 1;
                echo "<form action=\"compra3prod.php\" method=\"post\">
                            <div class=\"container space\">
                                    <br><h5> Id Producto: </h5><br> 
                                <input type=\"text\" class=\"form_control\" name=\"id_prod\">
                            </div>
                            <div class=\"container space\">
                                    <br><h5> Cantidad: </h5><br> 
                                <input type=\"text\" class=\"form_control\" name=\"cant\">
                            </div>
                            <div class=\"container space\">
                                    <br><h5> Cuotas: </h5><br> 
                                <input type=\"text\" class=\"form_control\" name=\"cuotas\" value=\"1\">
                                <button type=\"submit\" class=\"btn btn-primary\" value=\"Login\">Pagar</button><
                            </div>
                        /form>";     

                $query1 = "SELECT p.id_producto, p.nombre, p.precio, p.descripcion FROM producto AS p, rtiendaproducto AS r WHERE r.id_tienda = '$id_tienda' AND r.id_producto = p.id_producto";
                $result1 = $db -> prepare($query1);
                $result1 -> execute();
                $productos = $result1 -> fetchAll(); 
                echo "<div class=\"container space\">
                            <a class=\"btn btn-warning\" href=\"compra.php\" role=\"button\">Atras</a>
                        </div>";

                echo "<br><h3> Productos Disponibles</h3><br>";

                echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Id</th><th class=\"querytext\" scope=\"col\">Nombre</th><th class=\"querytext\" scope=\"col\">Precio</th><th class=\"querytext\" scope=\"col\">Descripcion</th></tr></thead><tbody>";
                foreach ($productos as $producto) {
                    echo "<tr><td class=\"querytext\">$producto[0]</td><td class=\"querytext\">$producto[1]</td><td class=\"querytext\">$producto[2]</td><td class=\"querytext\">$producto[3]</td></tr>";
                }
                echo "</tbody></table>";          
            }   
        };
        if ($tiendaorserv == 0){
            $query = "SELECT id_tienda_s FROM tiendadeservicio";
            $result = $db -> prepare($query);
            $result -> execute();
            # Ojo, fetch() nos retorna la primer fila, fetchAll()
            # retorna todas.
            $tiendas = $result -> fetchAll(); 
            foreach ($tiendas as $tien) {
                if ($tien[0] == $id_tienda){
                    $tiendaorserv = -1;
                    echo "<form action=\"compra3serv.php\" method=\"post\">
                                <div class=\"container space\">
                                    <br><h5> Id Servicio: </h5><br>  
                                    <input type=\"text\" class=\"form_control\" name=\"id_prod\">
                                </div>
                                <div class=\"container space\">
                                    <br><h5> Cuotas: </h5><br>  
                                    <input type=\"text\" class=\"form_control\" name=\"cuotas\" value=\"1\">
                                    <button type=\"submit\" class=\"btn btn-primary\" value=\"Login\">Pagar</button><
                            </div>
                            </form>";

                    $query2 = "SELECT p.id_servicio, p.nombre, p.precio, p.descripcion FROM servicio AS p, rtiendaservicio AS r WHERE r.id_tienda_s = '$id_tienda' AND r.id_servicio = p.id_servicio";
                    $result2 = $db -> prepare($query2);
                    $result2 -> execute();
                    $servicios = $result2 -> fetchAll();
                    echo "<div class=\"container space\">
                            <a class=\"btn btn-warning\" href=\"compra.php\" role=\"button\">Atras</a>
                        </div>";

                    echo "<br><h3> Servicios Disponibles</h3><br>";

                    echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">Id</th><th class=\"querytext\" scope=\"col\">Nombre</th><th class=\"querytext\" scope=\"col\">Precio</th><th class=\"querytext\" scope=\"col\">Descripcion</th></tr></thead><tbody>";
                    foreach ($servicios as $servicio) {
                        echo "<tr><td class=\"querytext\">$servicio[0]</td><td class=\"querytext\">$servicio[1]</td><td class=\"querytext\">$servicio[2]</td><td class=\"querytext\">$servicio[3]</td></tr>";
                    }
                   
                    echo "</tbody></table>";                           
                }   
            };        
        }
        if ($tiendaorserv == 0){
            echo "<div class=\"container space\">
                    <br><h5> Tienda No Encontrada</h5><br>  
                    <a class=\"btn btn-warning\" href=\"compra.php\" role=\"button\">Atras</a>
                </div>";
        }
        
      ?>
  </div>
</body>
</html>
