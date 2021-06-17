<?php 
  session_start();
  if($_SESSION['nome'] == "" && $_SESSION['sobrenome'] == "")
  {
    $_SESSION['expirado'] = 1;
    header('location:index.php');
  }

  include "conexao_customer_huawei.php";
  $numAtendimento = $_POST['numAtendimento'];
  $nome = $_SESSION['nome']." ".$_SESSION['sobrenome'];
  $sql = "SELECT [tx_Numero_Atendimento] [INDICE], 
  cb_Canal_Vendas, 
  tx_nome,
  tx_login,
  tx_CPF_CNPJ,
  cb_contrato_proposta,
  tx_contrato,
  tx_ocorrencia_criada,
  cb_Modalidade_Atendimento,
  cb_Estado,
  cb_cidade,
  tx_loja_vendedor

  FROM [CUSTOMER_NCM].[dbo].[CUSTOMER_HUAWEI_HOTLINE] WITH(NOLOCK) 
  WHERE TX_NUMERO_ATENDIMENTO = '".$numAtendimento."'"; 

  $res = mssql_query($sql);
  $qtd_atendimento = mssql_num_rows($res);

  if($qtd_atendimento == 0)
  {
    $novoAtendimento = 1;
  }
  else
  {
    $novoAtendimento = 0;
    $dados = mssql_fetch_array($res);
    $indice= utf8_decode($dados['INDICE']);	
    $canVendas = utf8_decode($dados['cb_Canal_Vendas']);
    $nomVendedor = utf8_decode($dados['tx_nome']);
    $logVendedor = utf8_decode($dados['tx_login']);
    $cpfCnpj = utf8_decode($dados['tx_CPF_CNPJ']);
    $opcContratoProposta = utf8_decode($dados['cb_contrato_proposta']);
    $conProposta = utf8_decode($dados['tx_contrato']);
    $ocoCriada = utf8_decode($dados['tx_ocorrencia_criada']);
    $modAtendimento = utf8_decode($dados['cb_Modalidade_Atendimento']);
    $estado = utf8_decode($dados['cb_Estado']);
    $cidade = utf8_encode(utf8_decode($dados['cb_cidade']));
    $lojVendedor = utf8_decode($dados['tx_loja_vendedor']);    
  }
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
    function habilitaCampos()
    {
      ajaxGet("carrega_estado.php?uf="+document.getElementById('estado').value, document.getElementById('estado'), true);
      ajaxGet("carrega_status_contato.php", document.getElementById('staContatoAtendimento'), true);

      if(document.getElementById('novoAtendimento').value == 1)
      {
        document.getElementById('badgeNovo').style.display = "inline";
      }
      else
      {
        document.getElementById('badgeNovo').style.display = "none";
      }
    }

    function changeEstado()
    {
      ajaxGet('carrega_cidade.php?uf='+document.getElementById('estado').value, document.getElementById('cidade'), true);
    }

    function changeOrigemAtendimento()
    {
      ajaxGet('carrega_status.php?origem='+document.getElementById('oriAtendimento').value, document.getElementById('staAtendimento'), true);
    }

    function carregaStatusAtendimento()
    {
      ajaxGet('carrega_detalhe.php?status='+document.getElementById('staAtendimento').value+'&origem='+document.getElementById('oriAtendimento').value+'&conpro='+document.getElementById('opcContratoProposta').value, document.getElementById('detAtendimento'), true);
    }

    function changeStatusAtendimemto()
    {
      carregaStatusAtendimento();    
    }

    function changeOpcaoContratoProposta()
    {
      carregaStatusAtendimento(); 
    }

    function validaCampos()
    {
      String.prototype.trim  = function() {return this.replace(/^\s+|\s+$/g,"");}
			String.prototype.ltrim = function() {return this.replace(/^\s+/,"");}
      String.prototype.rtrim = function() {return this.replace(/\s+$/,"");}

      var msg = "";
      var origem = document.getElementById('oriAtendimento').value;
      var canalVendas = document.getElementById('canVendas').value;
      var nomeVendedor = document.getElementById('nomVendedor').value;
      var loginVendedor = document.getElementById('logVendedor').value;
      var cpfCnpj = document.getElementById('cpfCnpj').value;
      var opcaoContratoProposta = document.getElementById('opcContratoProposta').value;
      var contratoProposta = document.getElementById('conProposta').value;
      var ocorrenciaCriada = document.getElementById('ocoCriada').value;
      var modalidadeAtendimento = document.getElementById('modAtendimento').value;
      var estado = document.getElementById('estado').value;
      var cidade = document.getElementById('cidade').value;
      var lojaVendedor = document.getElementById('lojVendedor').value;
      var statusContatoAtendimento = document.getElementById('staContatoAtendimento').value;
      var statusAtendimento = document.getElementById('staAtendimento').value;
      var detalheAtendimento = document.getElementById('detAtendimento').value;

      if(origem == "" || origem == "SELECIONE:")
      {
        msg += "Selecione o campo 'Origem do Atendimento:'!\n"
      }

      if(canalVendas.trim() == "")
      {
        msg += "Preencha o campo 'Canal de Vendas:'!\n"
      }
      
      if(nomeVendedor.trim() == "")
      {
        msg += "Preencha o campo 'Nome Vendedor:'!\n"
      }

      if(loginVendedor.trim() == "")
      {
        msg += "Preencha o campo 'Login Vendedor:'!\n"
      }

      if(cpfCnpj.trim() == "")
      {
        msg += "Preencha o campo 'CPF/CNPJ:'!\n"
      }
      else if(cpfCnpj.length == 10 || cpfCnpj.length == 11)
      {
        var cpf = cpfCnpj;
        if(cpf.length == 10)
        {
          cpf = '0' + cpf;
        }
        if (cpf.length != 11     || cpf == ''    ||
          cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || 
          cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || 
          cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" ||  
          cpf == "99999999999" || cpf == "12345678901") 
        {
          msg += "1.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
        } 
        else 
        {

          soma = 0;

          for(i = 0; i < 9; i++)
          {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
          }

          resto = 11 - (soma % 11);

          if(resto == 10 || resto == 11)
          {
            resto = 0;
          }

          if(resto != parseInt(cpf.charAt(9))) 
          {
            msg += "2.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
          } 
          else 
          {
          
            soma = 0;

            for(i = 0; i < 10; i ++)
            {
              soma += parseInt(cpf.charAt(i)) * (11 - i);
            }

            resto = 11 - (soma % 11);

            if(resto == 10 || resto == 11)
            {
              resto = 0;
            }

            if(resto != parseInt(cpf.charAt(10))) 
            {
              msg += "3.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
            }
          }
        }
      }
      else if(cpfCnpj.length == 13 || cpfCnpj.length == 14)
      {        
        cnpj = cpfCnpj.replace(/[^\d]+/g,'');
      
        if (cnpj == "00000000000000" || 
          cnpj == "11111111111111" || 
          cnpj == "22222222222222" || 
          cnpj == "33333333333333" || 
          cnpj == "44444444444444" || 
          cnpj == "55555555555555" || 
          cnpj == "66666666666666" || 
          cnpj == "77777777777777" || 
          cnpj == "88888888888888" || 
          cnpj == "99999999999999") 
        {
          msg += "4.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
        } 
        else 
        {
          tamanho = cnpj.length - 2
          numeros = cnpj.substring(0,tamanho);
          digitos = cnpj.substring(tamanho);
          soma = 0;
          pos = tamanho - 7;
          for (i = tamanho; i >= 1; i--) 
          {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
              pos = 9;
          }
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(0)) 
          {
            msg += "5.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
          } 
          else 
          {			
            tamanho = tamanho + 1;
            numeros = cnpj.substring(0,tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) 
            {
              soma += numeros.charAt(tamanho - i) * pos--;
              if (pos < 2)
              pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1)) 
            {
              msg += "6.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
            }           
          }
        }
      }

      if (opcaoContratoProposta == "" || opcaoContratoProposta == "SELECIONE:")
      {
        msg += "Selecione o campo 'Opção Contrato ou Proposta:'!\n";
      }

      if (contratoProposta.trim() == "")
      {
        msg += "Preencha o campo 'Contrato/Proposta:'!\n";
      }
      else if(isNaN(contratoProposta))
      {
        msg += "1.Preencha o campo 'Contrato/Proposta:' somente com valores numéricos!\n";
      }
      else if(contratoProposta.indexOf("e") > -1 || contratoProposta.indexOf("E") > -1 || contratoProposta.indexOf(".") > -1 )
      {
        msg += "2.Preencha o campo 'Contrato/Proposta:' somente com valores numéricos!\n";
      }

      if (ocorrenciaCriada.trim() == "")
      {
        msg += "Preencha o campo 'Ocorrência Criada:'!\n";
      }

      if (modalidadeAtendimento == "" || modalidadeAtendimento == "SELECIONE:")
      {
        msg += "Selecione o campo 'Modalidade Atendimento:'!\n";
      }

      if (estado == "" || estado == "SELECIONE:")
      {
        msg += "Selecione o campo 'Estado:'!\n";
      }

      if (cidade == "" || cidade == "SELECIONE:")
      {
        msg += "Selecione o campo 'Cidade:'!\n";
      }

      if (lojaVendedor.trim() == "")
      {
        msg += "Preencha o campo 'Loja Vendedor:'!\n";
      }

      if (statusContatoAtendimento == "" || statusContatoAtendimento == "0")
      {
        msg += "Selecione o campo 'Status do Atendimento:'!\n";
      }

      if (statusAtendimento == "" || statusAtendimento == "0")
      {
        msg += "Selecione o campo 'Defina os atendimentos realizados nesta ligação:'!\n";
      }

      if (detalheAtendimento == "" || detalheAtendimento == "0" || detalheAtendimento == "SELECIONE:")
      {
        msg += "Selecione o campo 'Detalhe do Atendimento:'!\n";
      }

      if(msg)
      {
        alert(msg);
      }
      else
      {
        finalizarHuawei.submit();
      }
    }
  </script>
  <body class="bg-light" onload="habilitaCampos();">
    <form name="finalizarHuawei" id="finalizarHuawei" method="post" action="salvar.php" onKeyUp= "" enctype="multipart/form-data">
      <div class="container">
        <div class="py-3 text-center">
          <img class="mb-4" src="img/Logo.ico" alt="" width="56" height="56">
          <h2>Huawei Formulário</h2>
        </div>
        <div class="row">      
          <div class="col-md-12 order-md-1">
            <form class="needs-validation" novalidate>
              <div class="row">
                <div class="col-md-2 mb-3">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="username">Número do Atendimento: <b> <?php echo $_POST['numAtendimento'];?> </b> <span id="badgeNovo" class="badge badge-info">Novo</span></label>                
                </div>
                <div class="col-md-2 mb-3">
                </div>
              </div>

              <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="oriAtendimento">Origem do Atendimento:</label>
                    <select class="custom-select d-block w-100" id="oriAtendimento" name="oriAtendimento"  onchange="changeOrigemAtendimento();" required>
                      <option value="" selected>SELECIONE:</option>
                      <option value="CLARO BRASIL SEM CABO">CLARO BRASIL SEM CABO</option>
                      <option value="CLARO BRASIL COM CABO">CLARO BRASIL COM CABO</option>
                    </select>
                    <div class="invalid-feedback">
                      Selecione Origem do Atendimento
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2 mb-3">
                  <label for="canVendas">Canal de Vendas:</label>
                  <input type="text" class="form-control" id="canVendas" name="canVendas" value="<?php echo $canVendas; ?>" required>
                  <div class="invalid-feedback">
                    Informe o Canal de Vendas
                  </div>
                </div>
                <div class="col-md-5 mb-3">
                  <label for="nomVendedor">Nome Vendedor:</label>
                  <input type="text" class="form-control" id="nomVendedor" name="nomVendedor" value="<?php echo $nomVendedor; ?>" required>
                  <div class="invalid-feedback">
                    Informe o Nome do Vendedor
                  </div>
                </div>

                <div class="col-md-2 mb-3">
                  <label for="logVendedor">Login Vendedor:</label>
                  <input type="text" class="form-control" id="logVendedor" name="logVendedor" value="<?php echo $logVendedor; ?>" required>
                  <div class="invalid-feedback">
                    Informe o Login Vendedor
                  </div>
                </div>

                <div class="col-md-3 mb-3">
                  <label for="cpfCnpj">CPF/CNPJ:</label>
                  <input type="text" class="form-control" id="cpfCnpj" name="cpfCnpj" value="<?php echo $cpfCnpj; ?>" required>
                  <div class="invalid-feedback">
                    Informe o CPF ou CNPJ
                  </div>
                </div>
              </div>  

              <div class="row">
                <div class="col-md-3 mb-3">
                  <label for="opcContratoProposta">Opção Contrato ou Proposta:</label>
                  <select class="custom-select d-block w-100" id="opcContratoProposta" name="opcContratoProposta" onchange="changeOpcaoContratoProposta();" required>
                    <option value="<?php if($opcContratoProposta != "" ){echo $opcContratoProposta;}else {echo '';} ?>" selected><?php if($opcContratoProposta != "" ){echo $opcContratoProposta;}else {echo 'SELECIONE:';} ?></option>
                    <option value="CONTRATO">CONTRATO</option>
                    <option value="PROPOSTA">PROPOSTA</option>
                  </select>
                  <div class="invalid-feedback">
                    Selecione Contrato ou Proposta
                  </div>
                </div>

                <div class="col-md-2 mb-3">
                  <label for="conProposta">Contrato/Proposta:</label>
                  <input type="text" class="form-control" id="conProposta" name="conProposta"  value="<?php echo $conProposta; ?>" required>
                  <div class="invalid-feedback">
                    Informe o Contrato/Proposta
                  </div>
                </div>

                <div class="col-md-4 mb-3">
                  <label for="ocoCriada">Ocorrência Criada:</label>
                  <input type="text" class="form-control" id="ocoCriada" name="ocoCriada" value="<?php echo $ocoCriada; ?>" required>
                  <div class="invalid-feedback">
                    Informe a Ocorrência
                  </div>
                </div>

                <div class="col-md-3 mb-3">
                  <label for="modAtendimento">Modalidade Atendimento:</label>
                  <select class="custom-select d-block w-100" id="modAtendimento" name="modAtendimento" required>
                    <option value="<?php if($modAtendimento != "" ){echo $modAtendimento;}else {echo '';} ?>" selected><?php if($modAtendimento != "" ){echo $modAtendimento;}else {echo 'SELECIONE:';} ?></option>
                    <option value="PME">PME</option>
                    <option value="INDIVIDUAL">INDIVIDUAL</option>
                    <option value="COLETIVO">COLETIVO</option>
                  </select>
                  <div class="invalid-feedback">
                    Selecione Modalidade do Atendimento
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2 mb-3">
                    <label for="estado">Estado:</label>
                    <select class="custom-select d-block w-100" id="estado" name="estado"  onchange="changeEstado();" required>
                      <option value="<?php if($estado != "" ){echo $estado;}else {echo '';} ?>" selected><?php if($estado != "" ){echo $estado;}else {echo 'SELECIONE:';} ?></option>
                    </select>
                    <div class="invalid-feedback">
                      Selecione Estado
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="cidade">Cidade:</label>
                    <select class="custom-select d-block w-100" id="cidade" name="cidade" required>
                      <option value="<?php if($cidade != "" ){echo $cidade;}else {echo '';} ?>" selected><?php if($cidade != "" ){echo $cidade;}else {echo 'SELECIONE:';} ?></option>
                    </select>
                    <div class="invalid-feedback">
                      Selecione Cidade
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                  <label for="lojVendedor">Loja Vendedor:</label>
                  <input type="text" class="form-control" id="lojVendedor" name="lojVendedor" value="<?php echo $lojVendedor; ?>" required>
                  <div class="invalid-feedback">
                    Informe a Loja do Vendedor
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="staContatoAtendimento">Status do Atendimento:</label>
                    <select class="custom-select d-block w-100" id="staContatoAtendimento" name="staContatoAtendimento" required>
                      <option value="SELECIONE:" selected>SELECIONE:</option>
                    </select>
                    <div class="invalid-feedback">
                      Selecione Status do Atendimento
                    </div>
                </div>

                <div class="col-md-5 mb-3">
                    <label for="staAtendimento">Defina os atendimentos realizados nesta ligação:</label>
                    <select class="custom-select d-block w-100" id="staAtendimento" name="staAtendimento" onchange="changeStatusAtendimemto();" required>
                      <option value="SELECIONE:" selected>SELECIONE:</option>
                    </select>
                    <div class="invalid-feedback">
                      Selecione atendimento realizado nesta ligação
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                <label for="detAtendimento">Detalhe do Atendimento:</label>
                    <select class="custom-select d-block w-100" id="detAtendimento" name="detAtendimento" required>
                      <option value="SELECIONE:" selected>SELECIONE:</option>
                    </select>
                    <div class="invalid-feedback">
                      Selecione detalhe do atendimento
                    </div>
                </div>
              </div>
              <div class="row">
                  <?php 	
                  /*
                  while ($row = mssql_fetch_array($protocolos_encontrados))
                  {
                    
                                                                              
                    echo "
                    <tr>
                    <td>
                      <div class='col-md-4 col-xs-4'>
                        <a class='btn btn-primary btn-block' href='".$site."' role='button'>".utf8_encode($row['Protocolo'])."</a>
                      </div>
                      <div class='col-md-4 col-xs-4'>										
                      </div>
                      <div class='col-md-4 col-xs-4'>
                      </div>									
                    </td>
                      
                    <td>".utf8_encode($dias)."</td>
                    <td>
                      <div class='col-md-4 col-xs-4' style='".$classificacao."'>
                        <h2></h2>
                      </div>
                      <div class='col-md-4 col-xs-4'>										
                      </div>
                      <div class='col-md-4 col-xs-4' >
                      </div>									
                    </td>
                    </tr>								
                    ";								
                  }	*/                  
                ?>
              </div>
              <hr class="mb-2">
              <button class="btn btn-primary btn-lg btn-block" type="submit" onclick="validaCampos();">Finalizar Atendimento</button>
            </form>
          </div>
        </div>

        <input type="hidden"  id="novoAtendimento" name="novoAtendimento" value="<?php echo $novoAtendimento; ?>">
        <input type="hidden"  id="numAtendimento" name="numAtendimento" value="<?php echo $numAtendimento; ?>">

        <footer class="my-4 pt-4 text-muted text-center text-small">
          <p class="mb-1">Operador: <b><?php echo $nome; ?></b></p>
          <p class="mb-1">&copy; 2020-2021 Motiva Contact Center</p>
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
    </form>
  </body>
</html>
