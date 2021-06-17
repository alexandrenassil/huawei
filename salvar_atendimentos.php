<?php
  session_start();

  include "conexao_customer_huawei.php";
  $id = $_POST['idOperador'];
  $nome = $_POST['nomeOperador'];
  $staAtendimento = $_POST['status'];
  $detAtendimento = $_POST['detalhe'];
  $numAtendimento = $_POST['atendimento'];
    
  $sql_insert = "INSERT INTO [CUSTOMER_NCM].[dbo].[HOTLINE_STATUS_TABULADOS_TESTE] (
  ID_OPERADOR, 
  NOME_OPERADOR, 
  STATUS_ATENDIMENTO, 
  DETALHE_ATENDIMENTO, 
  INDICE, 
  DATA_INSERCAO)
        
  VALUES (
      
  '".$id."', 
  '".$nome."', 
  '".$staAtendimento."', 
  '".$detAtendimento."', 
  '".$numAtendimento."', 
  GETDATE())";
  
  mssql_query($sql_insert);

?>