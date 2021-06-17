<?php 
  session_start();
  $nome = $_SESSION['nome']." ".$_SESSION['sobrenome'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/Logo.ico">
    <title>Huawei</title>

    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="ajax.js"></script>
    <script type="text/javascript" src="micoxAjax.js"></script>
    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
  </head>
  <script>
    
    function consultarAtendiemnto()
    {
      String.prototype.trim  = function() {return this.replace(/^\s+|\s+$/g,"");}
			String.prototype.ltrim = function() {return this.replace(/^\s+/,"");}
      String.prototype.rtrim = function() {return this.replace(/\s+$/,"");}
      var msg = "";
      var numAtendimento = document.getElementById('numAtendimento').value;

      if(numAtendimento.trim() == "")
      {
        msg = "Preencha o 'Número do Atendimento'!\n";
      }
      else if(isNaN(numAtendimento))
      {
        msg = "Preencha o 'Número do Atendimento' somente com valores numéricos!\n";
      }
      else if(numAtendimento.indexOf("e") > -1 || numAtendimento.indexOf("E") > -1 || numAtendimento.indexOf(".") > -1)
      {
        msg = "Preencha o 'Número do Atendimento' corretamente!\n";
      }
      else if(numAtendimento.length > 18)
      {
        msg = "Preencha o 'Número do Atendimento' corretamente, numéro máximo permitido extrapolado, até 18 caracteres!\n";
      }

      if(msg)
      {
        alert(msg);
      }
      else
      {
        consultarHuawei.submit();
      }
    }
  </script>
  <body class="bg-light" onload="">

    <div class="container">
      <div class="py-5 text-center">
        <img class="mb-5" src="img/Logo.ico" alt="" width="56" height="56">
        <h2>Huawei Atendimento</h2>
      </div>
      <div class="row">      
        <div class="col-md-12 order-md-1">
          <form class="needs-validation" name="consultarHuawei" id="consultarHuawei" method="post" action="finalizar.php" onKeyUp= "" >
            <div class="row">
              <div class="col-md-4 mb-3">
              </div>
              <div class="col-md-4 mb-3">
                  <label for="username">Número do Atendimento:</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="numAtendimento" name="numAtendimento" placeholder="Informe o número do atendimento..." required>
                    <span class="input-group-btn">
                      <button class="btn btn-search" type="button" onclick="consultarAtendiemnto();"><i class="fa fa-search fa-fw"></i> Buscar</button>
                    </span>
                    <div class="invalid-feedback">
                    Informe o número de atendimento
                    </div>
                  </div>                   
              </div>
              <div class="col-md-4 mb-3">
                
              </div>
            </div>            
          </form>
        </div>
      </div>
      <input type="hidden"  id="nomeOperador" name="nomeOperador" value="<?php echo $nome; ?>">
      <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">Operador: <b><?php echo $nome; ?></b></p>
        <p class="mb-2">&copy; 2020-2021 Motiva Contact Center</p>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>
<?php 
    if ($_SESSION['inserido'] == 1)
    {  
      echo "<script>alert('Atendimento salvo com sucesso!')</script>"; 
      unset ($_SESSION['inserido']);
    } 
    else if ($_SESSION['inserido'] == 2)
    {  
      echo "<script>alert('Ocorreu um erro, favor inserir atendimento novamente, caso persista favor informar o número do atendimento ao supervisor responsável!')</script>"; 
      unset ($_SESSION['inserido']);
    }      
?>