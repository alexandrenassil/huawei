<?php
  session_start();
  include "conexao_customer_huawei.php";

  $nome = $_SESSION['nome']." ".$_SESSION['sobrenome'];
  $login = $_SESSION['login'];
  $numAtendimento = $_POST['numAtendimento'];
  $oriAtendimento = utf8_decode($_POST['oriAtendimento']);
  $canVendas = utf8_decode($_POST['canVendas']);
  $nomVendedor = utf8_decode($_POST['nomVendedor']);
  $logVendedor = utf8_decode($_POST['logVendedor']);
  $cpfCnpj = utf8_decode($_POST['cpfCnpj']);
  $opcContratoProposta = utf8_decode($_POST['opcContratoProposta']);
  $conProposta = utf8_decode($_POST['conProposta']);
  $ocoCriada = utf8_decode($_POST['ocoCriada']);
  $modAtendimento = utf8_decode($_POST['modAtendimento']);
  $estado = utf8_decode($_POST['estado']);
  $cidade = utf8_decode($_POST['cidade']);
  $lojVendedor = utf8_decode($_POST['lojVendedor']); 
  $staContatoAtendimento = $_POST['staContatoAtendimento']; 
  $staAtendimento = $_POST['staAtendimento']; 
  $detAtendimento = $_POST['detAtendimento']; 
  
  $sql_max = "SELECT MAX(INDICE) + 1 [INDICE_ADD] FROM [CUSTOMER_NCM].[dbo].[CUSTOMER_HUAWEI_HOTLINE]";
  $res_max = mssql_query($sql_max);
  $array_indice_max = mssql_fetch_array($res_max);
  $indice_max = utf8_decode($array_indice_max['INDICE_ADD']);	

  $sql = "SELECT INDICE 
  FROM [CUSTOMER_NCM].[dbo].[CUSTOMER_HUAWEI_HOTLINE] 
  WHERE tx_Numero_Atendimento = '".$numAtendimento ."'";
  $res = mssql_query($sql);
  $array_indice = mssql_fetch_array($res);
  $indice = utf8_decode($array_indice_max['INDICE']);	
  $encontrado = mssql_num_rows($res);

  if($indice == "")
  {
    $indice = $indice_max;
  }


  

  if($encontrado > 0 && $oriAtendimento != "")
  {    
    $sql_update = "UPDATE A SET 
      cb_Origem_Atendimento = '".$oriAtendimento."',
      cb_Origem_Atendimento_val = '".$oriAtendimento."',
      cb_Canal_Vendas = '".$canVendas."', 
      cb_Canal_Vendas_VAL = '".$canVendas."', 
      tx_nome = '".$nomVendedor."', 
      tx_login = '".$logVendedor."', 
      tx_CPF_CNPJ = '".$cpfCnpj."', 
      cb_contrato_proposta = '".$opcContratoProposta."', 
      cb_contrato_proposta_VAL = '".$opcContratoProposta."', 
      tx_contrato = '".$conProposta."', 
      tx_ocorrencia_criada = '".$ocoCriada."', 
      cb_Modalidade_Atendimento = '".$modAtendimento."', 
      cb_Modalidade_Atendimento_VAL = '".$modAtendimento."', 
      cb_Estado = '".$estado."', 
      cb_Estado_VAL = '".$estado."', 
      cb_cidade = '".$cidade."', 
      cb_cidade_VAL = '".$cidade."',       
      tx_loja_vendedor = '".$lojVendedor."',  
      cb_status_contato = '".$staContatoAtendimento."', 
      cb_status_contato_VAL = '".$staContatoAtendimento."', 
      cb_status_atendimento = '".$staAtendimento."', 
      cb_status_atendimento_VAL = '".$staAtendimento."', 
      cb_detalhe_atendimento = '".$detAtendimento."', 
      cb_detalhe_atendimento_VAL = '".$detAtendimento."',
      tx_Hora_Contato = CONVERT(VARCHAR(10), GETDATE(), 108), 
      tx_Data_Contato = CONVERT(VARCHAR(10), GETDATE(), 103), 
      tx_ID_OPERADOR = '".$login."', 
      TX_NOME_OPERADOR = '".$nome."',
      tx_status_final = '".$staContatoAtendimento."' 
    
    FROM [CUSTOMER_NCM].[dbo].[CUSTOMER_HUAWEI_HOTLINE] A
    WHERE tx_Numero_Atendimento = '".$numAtendimento ."'";
    
    try {
      mssql_query($sql_update);

      $sql_insert_aux = "INSERT INTO [CUSTOMER_NCM].[dbo].[HOTLINE_STATUS_TABULADOS] 
      (STATUS_ATENDIMENTO, DETALHE_ATENDIMENTO, ID_OPERADOR, NOME_OPERADOR, DATA_INSERCAO, INDICE, STATUS_CONTATO) 
      VALUES 
      ('".$staAtendimento."', '".$detAtendimento."', '".$login."', '".$nome."', GETDATE(), '".$indice."', '".$staContatoAtendimento."')";
      $res_aux = mssql_query($sql_insert_aux);

    } catch (Exception $e) {
      $_SESSION['inserido'] = 2;
      header('location:consultar.php'); 
    }    

    $_SESSION['inserido'] = 1;
    header('location:consultar.php');
  }
  else if($oriAtendimento != "")
  {
    $sql_insert = "INSERT INTO [CUSTOMER_NCM].[dbo].[CUSTOMER_HUAWEI_HOTLINE] (
      INDICE,
      tx_numero_atendimento,
      cb_Origem_Atendimento,
      cb_Origem_Atendimento_val,
      cb_Canal_Vendas, 
      cb_Canal_Vendas_val, 
      tx_nome,
      tx_login,
      tx_CPF_CNPJ,
      cb_contrato_proposta,
      cb_contrato_proposta_val,
      tx_contrato,
      tx_ocorrencia_criada,
      cb_Modalidade_Atendimento,
      cb_Modalidade_Atendimento_val,
      cb_Estado,
      cb_Estado_val,
      cb_cidade,
      cb_cidade_val,
      tx_loja_vendedor,
      cb_status_contato,
      cb_status_contato_val,
      cb_status_atendimento,
      cb_status_atendimento_Val,
      cb_detalhe_atendimento,
      cb_detalhe_atendimento_Val,
      tx_Hora_Contato,
      tx_Data_Contato,
      tx_ID_OPERADOR,
      TX_NOME_OPERADOR,
      tx_status_final)
      
        VALUES (
          
          '".$indice."', 
          '".$numAtendimento."', 
          '".$oriAtendimento."', 
          '".$oriAtendimento."', 
          '".$canVendas."', 
          '".$canVendas."', 
          '".$nomVendedor."', 
          '".$logVendedor."', 
          '".$cpfCnpj."', 
          '".$opcContratoProposta."', 
          '".$opcContratoProposta."', 
          '".$conProposta."', 
          '".$ocoCriada."', 
          '".$modAtendimento."', 
          '".$modAtendimento."', 
          '".$estado."', 
          '".$estado."', 
          '".$cidade."', 
          '".$cidade."', 
          '".$lojVendedor."', 
          '".$staContatoAtendimento."', 
          '".$staContatoAtendimento."', 
          '".$staAtendimento."', 
          '".$staAtendimento."', 
          '".$detAtendimento."', 
          '".$detAtendimento."', 
          CONVERT(VARCHAR(10), GETDATE(), 108), 
          CONVERT(VARCHAR(10), GETDATE(), 103), 
          '".$login."',
          '".$nome."',
          '".$staContatoAtendimento."' 
        )";

        try {
          mssql_query($sql_insert);
          $sql_insert_aux = "INSERT INTO [CUSTOMER_NCM].[dbo].[HOTLINE_STATUS_TABULADOS] 
          (STATUS_ATENDIMENTO, DETALHE_ATENDIMENTO, ID_OPERADOR, NOME_OPERADOR, DATA_INSERCAO, INDICE, STATUS_CONTATO) 
          VALUES 
          ('".$staAtendimento."', '".$detAtendimento."', '".$login."', '".$nome."', GETDATE(), '".$indice."', '".$staContatoAtendimento."')";
          $res_aux = mssql_query($sql_insert_aux);

        } catch (Exception $e) {
          $_SESSION['inserido'] = 2;
          header('location:consultar.php'); 
        }  
        $_SESSION['inserido'] = 1;
        header('location:consultar.php');
  }

  
?>