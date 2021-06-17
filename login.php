<?php
  session_start();
  
  include 'conexao_customer_huawei.php';
  
  $loginOperador = $_POST['logOperador'];
  $senhaOperador = $_POST['senOperador'];
  $sql = "SELECT IDENT, 
  NOM, 
  PRENOM, 
  PASSWORD
  FROM [HN_ADMIN].[DBO].[IDENT]
  WHERE IDENT = '".$loginOperador."' AND  
  PASSWORD = '".$senhaOperador."' "; 

  $res = mssql_query($sql);
  $encontrado = mssql_num_rows($res);
  if($encontrado > 0 )
  {
    $dados = mssql_fetch_array($res);
    $_SESSION['login'] = $loginOperador;
    $_SESSION['senha'] = $senhaOperador;
    $_SESSION['nome'] = $dados['PRENOM'];
    $_SESSION['sobrenome'] = $dados['NOM'];
    header('location:consultar.php');
  }
  else
  {
    unset ($_SESSION['login']);
    unset ($_SESSION['senha']);
    $_SESSION['falha'] = 1;
    header('location:index.php');    
  }
  

?>