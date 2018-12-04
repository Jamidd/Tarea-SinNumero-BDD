<?php
    include_once "psql-config.php";
    try {
        $db = new PDO("pgsql:dbname=".DATABASE1.";host=".HOST1.";port=".PORT1.";user=".USER1.";password=".PASSWORD1);
    }
    catch(PDOException $e) {
    	echo "<h2>'$e->getMessage()'</h2>";
    }
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    $query = "SELECT id_usuario FROM usuario WHERE correo='$user' AND clave='$pass' LIMIT 1;";

    $result = $db -> prepare($query);
    $result -> execute();
    $nombres = $result -> fetchAll();
    if (count($nombres) == 0){
    	header('Location: login.php');
    	exit();
    } else {
    	if (session_status() != 1){
    		session_unset();
    	} else {
    		session_start();
    	}
    	$_SESSION["id"] = $nombres[0][0];
	//echo $_SESSION["id"];
	$id = $_SESSION["id"];
        header('Location: perfil.php');
    };
?>
