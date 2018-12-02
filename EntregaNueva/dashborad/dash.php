<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Dashboard</title>

      <link rel="icon" href="https://vignette4.wikia.nocookie.net/mariokart/images/1/17/CoinMK8.png">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
      <link rel="stylesheet" href="../css/style.css">

		<style type="text/css">
#container {
	min-width: 310px;
	max-width: 800px;
	height: 400px;
	margin: 0 auto
}
		</style>
	</head>
	<body>
<script src="code/highcharts.js"></script>
<script src="code/modules/exporting.js"></script>
<script src="code/modules/export-data.js"></script>

<div id="grafico1"></div>
<div class="container space">
        <?php 
            include_once "psql-config.php";
            
            $n_tienda = $_POST["nombre_tienda"];

			   try {
			        $db2 = new PDO("pgsql:dbname=".DATABASE1.";host=".HOST1.";port=".PORT1.";user=".USER1.";password=".PASSWORD1);
			    }
			   catch(PDOException $e) {
			   echo "<h2>'$e->getMessage()'</h2>";
			   }
			   $query_nombres ="SELECT *
			   FROM usuario ;";
			   $result4 = $db2 -> prepare($query_nombres);
            $result4 -> execute();
            $clientes_nombre = $result4 -> fetchAll();

            

            $conn = pg_pconnect("host=".HOST2." port=".PORT2." dbname=".DATABASE2." user=".USER2." password=".PASSWORD2);
				if (!$conn) {
  					echo "Ocurrió un error en la conexion.\n";
  					exit;
				}

				$query_tiendas_productos = pg_query($conn, "SELECT * FROM tienda 
            									WHERE LOWER(tienda.nombre) LIKE LOWER('%$n_tienda%') ");

				$query_tiendas_servicios = pg_query($conn, "SELECT * FROM tiendadeservicio AS tds
									            WHERE LOWER(tds.nombre) = LOWER('%$n_tienda%')");


            $tienda=pg_fetch_row($query_tiendas_productos);
            $id=$tienda[0];

            $clientes = pg_query($conn,"SELECT  compraproducto.id_usuario, SUM(rcompraproducto.cantidad::int*producto.precio::int)
            									FROM compraproducto, rcompraproducto, producto
           	 									WHERE compraproducto.id_tienda = $id  AND compraproducto.id_compra = rcompraproducto.id_compra AND producto.id_producto = rcompraproducto.id_producto::text 
            									GROUP BY compraproducto.id_usuario ");


            $dinero_por_mes= pg_query($conn, "SELECT date_trunc('month', compraproducto.fecha ) AS mes , SUM(rcompraproducto.cantidad::int*producto.precio::int)
 								FROM compraproducto, rcompraproducto, producto
								WHERE compraproducto.id_tienda = $id AND compraproducto.id_compra = rcompraproducto.id_compra AND producto.id_producto = rcompraproducto.id_producto::text
								GROUP BY mes
								ORDER BY 1");

            if (!$dinero_por_mes) {
  					echo "Ocurrió un error en consulta.\n";
 					exit;
				}
				while ($mes = pg_fetch_row($dinero_por_mes)) {
					$info= date_parse($mes[0]);
					$dateObj   = DateTime::createFromFormat('!m', $info["month"]);
					$nombre_mes = $dateObj->format('M');
					$meses[]= $info["month"];
  					$data[] = $mes[1];
					}
				#echo join($meses, ',');

				$compras_producto = pg_query($conn,"SELECT  producto.nombre, SUM(rcompraproducto.cantidad::int)
            									FROM compraproducto, rcompraproducto, producto
           	 									WHERE compraproducto.id_tienda = $id  AND compraproducto.id_compra = rcompraproducto.id_compra AND producto.id_producto = rcompraproducto.id_producto::text 
            									GROUP BY producto.id_producto ");
				while ($producto = pg_fetch_row($compras_producto)) {
					$nombres_productos[]= $producto[0];
					$cantidades_producto[]=$producto[1];
					}


         	

            echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">ID Cliente</th><th class=\"querytext\" scope=\"col\">Dinero Gastado</th></tr></thead><tbody>";


            while ($c = pg_fetch_row($clientes)) {
  					echo "<tr><td class=\"querytext\">$c[0]</td><td class=\"querytext\">$c[1]</td></tr>";
					}
            echo "</tbody></table>";


            
            echo "<table class=\"table querytable\"><thead><tr><th class=\"querytext\" scope=\"col\">ID tienda</th><th class=\"querytext\" scope=\"col\">Nombre</th><th class=\"querytext\" scope=\"col\">Ubicación</th><th class=\"querytext\" scope=\"col\">Telefono</th><th class=\"querytext\" scope=\"col\">Apertura</th><th class=\"querytext\" scope=\"col\">Cierre</th><th class=\"querytext\" scope=\"col\">Rubro</th><th class=\"querytext\" scope=\"col\">Correo</th><th class=\"querytext\" scope=\"col\">Tipo</th><th class=\"querytext\" scope=\"col\"></th></tr></thead><tbody>";

            
                echo "<tr><td class=\"querytext\">$tienda[0]</td><td class=\"querytext\">$tienda[1]</td><td class=\"querytext\">$tienda[2]</td><td class=\"querytext\">$tienda[3]</td><td class=\"querytext\">----</td><td class=\"querytext\">----</td><td class=\"querytext\">$tienda[4]</td><td class=\"querytext\">$tienda[5]</td><td class=\"querytext\"> Producto </td></tr>";

            while ($tienda = pg_fetch_row($query_tiendas_servicios)) {
                echo "<tr><td class=\"querytext\">$tienda2[0]</td><td class=\"querytext\">$tienda2[1]</td><td class=\"querytext\">$tienda2[2]</td><td class=\"querytext\">$tienda2[3]</td><td class=\"querytext\">$tienda2[4]</td><td class=\"querytext\">$tienda2[5]</td><td class=\"querytext\">$tienda2[6]</td><td class=\"querytext\">$tienda2[7]</td><td class=\"querytext\">Servicio</td><td class=\"querytext\"> Producto </td><td class=\"querytext\">
            <a class=\"btn btn-warning space\" href=\"detalles_tienda.php?tid=$tienda2[0]&type=1\" role=\"button\">Servicios ofrecidos</a></td></tr>";
            }
           
            echo "</tbody></table>";
        ?>        
</div>

<script type="text/javascript">

Highcharts.chart('grafico1', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Recaudaciones por mes'
    },
 
    xAxis: {
        categories: [<?php echo join($meses, ',') ?>]
    },
    yAxis: {
        title: {
            text: 'Dinero'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Dinero recaudado',
        data: [<?php echo join($data, ',') ?>]
    }]
});
		</script>
<div id="grafico_productos" style="min-width: 310px; height: 400px; margin: 0 auto"></div>



		<script type="text/javascript">

Highcharts.chart('grafico_productos', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Ventas por producto'
    },
    
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'numero'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'ventas',
        data: [<?php echo join($cantidades_producto, ',') ?>]

    }]
});
		</script>
	</body>
</html>