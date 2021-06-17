<?php

session_start();
include "conexao_customer_huawei.php";

 $indice = $_GET['indice'];
 $proposta = $_GET['proposta'];
 $pendencia = $_GET['pendencia'];


$script = "INSERT INTO [CUSTOMER_NCM].[dbo].[CUSTOMER_HUAWEI_HOTLINE_PENDENCIAS] (INDICE, CONTRATO_PROPOSTA, PENDENCIA, DATA_INSERT) VALUES (".$indice.", ".$proposta.", ".$pendencia.", GETDATE())";
$res = mssql_query($script);
$result = mssql_fetch_array($res);

echo $result;


?>