<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/Logo.ico">

    <title>Huawei</title>

	<script src="http://10.100.0.99/net/acessos/jquery.min.js"></script>
	<script src="http://10.100.0.99/net/acessos/bootstrap 3.4.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://10.100.0.99/net/acessos/bootstrap 3.4.0/css/bootstrap.min.css">
	<script src="http://10.100.0.99/net/acessos/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://10.100.0.99/net/acessos/bootstrap-3.4.1-dist/css/bootstrap.min.css">

	<script src="http://10.100.0.99/net/acessos/jquery-1.12.0.min.js"  integrity="sha256-Xxq2X+KtazgaGuA2cWR1v3jJsuMJUozyIXDB3e793L8="  crossorigin="anonymous"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript" src="ajax.js"></script>
	<script type="text/javascript" src="micoxAjax.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" src="css/bootstrap.min.css"></script>
	<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.11.4.custom/jquery-ui.css"/>
	<script type="text/javascript" src="js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

    <!-- Custom styles for this template -->
    <link href="floating-labels.css" rel="stylesheet">
  </head>

  <body>
    <form class="form-signin" name="loginHuawei" id="loginHuawei" enctype="multipart/form-data" method="post" action="login.php" onKeyUp= "">
      <div class="text-center mb-4">
        <img class="mb-4" src="img/Logo.ico" alt="" width="48" height="48">
        <h1 class="h3 mb-3 font-weight-normal">Huawei</h1>
      </div>

      <div class="form-label-group">
        <input id="logOperador" name="logOperador" class="form-control" placeholder="Usuário" required autofocus>
        <label for="logOperador">Usuário</label>
      </div>

      <div class="form-label-group">
        <input type="Password" id="senOperador" name="senOperador" class="form-control" placeholder="Senha" required>
        <label for="senOperador">Senha</label>
      </div>

      <div class="checkbox mb-3">
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Logar</button>
      <p class="mt-5 mb-3 text-muted text-center">&copy; 2020-2021 Motiva Contact Center</p>

      <?php 
      session_start();
      if ($_SESSION['falha'] == 1)
      {
        
        echo "<script>alert('Login/Senha inválidos!')</script>"; 
        unset ($_SESSION['falha']);
      }     
      ?>
    </form>
  </body>
</html>
