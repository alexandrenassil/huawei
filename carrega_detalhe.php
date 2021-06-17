<?php 

include "conexao_customer_huawei.php";

$fullstatus = utf8_decode($_GET['status']); // Status
$origem = $_GET['origem'];// origem do atendimento
$conpro = $_GET['conpro'];//contrato / proposta
$campanha = $_GET['campanha'];//Campanha

$arraystatus = explode("-", $fullstatus);
$status = $arraystatus[0];


if($campanha == "MUDANCA DE ENDERECO")
{
	if($status == 26)
	{
		$detail = "IN (1,2,3,4)";
	}
	else if ($status == 27)
	{
		$detail = "IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15)";
	}
}
else if ($campanha == "TRANSFERENCIA DE TITULARIDADE")
{
	if($status == 28)
	{
		$detail = "IN (1,2)";
	}
	else if ($status == 29)
	{
		$detail = "IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30)";
	}	
}
else if($status == 3)
{
	$detail = "NOT IN (0,5)";
}
else if($status == 7 && $origem == "CLARO BRASIL COM CABO" && $conpro == "CONTRATO")
{
	$detail = "IN (1,2,3,5,8,9,10,11,12,13,14,16,17)";
}
else if($status == 7 && $origem == "CLARO BRASIL COM CABO" && $conpro  == "PROPOSTA")
{
	$detail = "IN (1,2,3,4,5,6,7,8,9,10,11,12,14,15,16,17)";
}
else if($status == 10 && $origem == "CLARO BRASIL COM CABO")
{
	$detail = "IN (1,5,6,7)";
}
else if($status == 10 && $origem == "CLARO BRASIL SEM CABO")
{
	$detail = "IN (1,2,3,4)";
}
else
{
	$detail = "> 0";
}


$sql = "SELECT '0' [STATUSDETAIL], 'SELECIONE:' [STATUSTEXT] UNION ALL 
		SELECT STATUSDETAIL, STATUSTEXT 
		FROM HOTLINE_STATUS_ATENDIMENTO_V5 /*HOTLINE_STATUS_ATENDIMENTO_V5 HOTLINE_STATUS_ATENDIMENTO_DEV*/
		WHERE STATUSCODE = '".$status."' AND 
		STATUSDETAIL ".$detail." 
		ORDER BY  [STATUSDETAIL], STATUSTEXT"; 

$res = mssql_query($sql);

$num_detalhe = mssql_num_rows($res);

for($j=0;$j<$num_detalhe;$j++){
	$dados = mssql_fetch_array($res);
	$detalhe= "<option value='".$dados['STATUSDETAIL']."-".$dados['STATUSTEXT']."'>".$dados['STATUSTEXT'] ."</option>";
	echo utf8_encode($detalhe);
}

?>
