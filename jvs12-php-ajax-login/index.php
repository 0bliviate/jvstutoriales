<?php
session_start();

if ($_POST) {
	require_once 'libs/ez_sql_core.php';
	require_once 'libs/ez_sql_mysql.php';

	$conn = new ezSQL_mysql('root', '', 'jvs_tutoriales');

	$usuario = $conn->get_row("SELECT id_usuario, nombre, apellido FROM usuarios WHERE login = '" . $_POST['login']  . "' AND password = '" . sha1($_POST['pwd'])  . "'");

	if ($usuario) {
		$_SESSION['usuario_logeado'] = $usuario;
		header('Location: admin.php');
	} else {
		$error = 'Usuario y/o password incorrecto.';
	}
}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css">
		<title>JV Software | Tutorial 12</title>
		<style>
			.hero-unit {
				margin-top: 40px
			}
			.sidebar {
				background: #eee;
			}
			form, .actions {
				margin-bottom: 0
			}
			.error {
				color: red
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>
			$(function(){
				$('#login-form').submit(function(e) {
					e.preventDefault();

					$('#load').show();

					$.post('ajax.php', $(this).serialize(), function(resp) {
					  	if (!resp.error) {
					  		$('#load').hide();

					  		var html = '<h3>Hola, ' + resp.nombre + ' ' + resp.apellido + '!</h3>' +
										'<p>' +
											'<a href="logout.php">Logout</a>' +
										'</p>';
												
							$('.sidebar').html(html);

					  	} else {
					  		$('#load').hide();

					  		var error = '<p class="error">' +
											'Usuario y/o password incorrecto.' +
										'</p>';

							$('#login-form .error').remove();

							$('.actions').before(error);
					  	};
					}, 'json');
					
				});

			});
		</script>
	</head>
	<body>
		<div class="topbar">
	      <div class="topbar-inner">
	        <div class="container">
	          <a class="brand" href="index.php">JV Software</a>
	          <ul class="nav">
	            <li><a href="admin.php">Admin</a></li>
	          </ul>
	        </div>
	      </div>
	    </div>
		<div class="container">
			<div class="hero-unit">
				<h1>Tutorial Login AJAX</h1>
			</div>
			<div class="row">
				<div class="sidebar span5">
					<?php if (!isset($_SESSION['usuario_logeado'])) : ?>
					<form id="login-form" action="" method="post" class="form-stacked">
						<h3>Acceso</h3>
						<div class="clearfix">
							<label for="login">Usuario:</label>
							<div class="input">
								<input type="text" name="login" id="login">
							</div>
						</div>
						<div class="clearfix">
							<label for="pwd">Password:</label>
							<div class="input">
								<input type="password" name="pwd" id="pwd">
							</div>
						</div>
						<?php if (isset($error)): ?>
							<p class="error">
								<?php echo $error; ?>
							</p>
						<?php endif ?>
						<div class="actions">
							<input type="submit" value="Login" class="btn primary">
							<img src="img/ajax-loader.gif" id="load" alt="Cargando" class="hide">
						</div>
					</form>
					<?php else : ?>
						<h3>Hola, <?php echo $_SESSION['usuario_logeado']->nombre . ' ' . $_SESSION['usuario_logeado']->apellido ?>!</h3>
						<p>
							<a href="logout.php">Logout</a>
						</p>
					<?php endif; ?>
				</div>
				<div class="content span11">
					<h2>Contenido</h2>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</div>
			</div>
			<footer>
				<p>
					 &copy; JV Software 2011
				</p>
			</footer>
		</div>
	</body>
</html>