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
	<div class="container text-center main-cont">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6 text-center">
				<h1 class='Login'>Login</h1>
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="row main-cont">
			<div class="col-md-4"></div>
			<div class="col-md-4">
			<form action="login_handler.php" method="post">
					<div class="form-group">
						<label class="b-label" for="user">Nombre usuario:</label><br>
						<input type="email" class="form_control" name="user">
					</div>
					<div class="form-group">
						<label class="b-label" for="pass">Contraseña:</label><br>
						<input type="password" class="form_control" name="pass">
					</div>
					<button type="submit" class="btn btn-primary" value="Login">Entrar</button>
				</form>
				<a class="btn btn-warning space" href="../../index.php" role="button">Volver a inicio</a>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
</body>
</html>