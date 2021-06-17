<?php 

include "conexao_customer_huawei.php";
$origem = utf8_decode($_GET['origem']);
$campanha = utf8_decode($_GET['campanha']);
$contato = utf8_decode($_GET['statusContato']);

if($campanha == "MPLAY")
{
	if($contato == "1-ATENDIMENTO COM SUCESSO")
	{
		$statuscode = "12,14,16,17,18,19,20,21,22,23";
	}
	else if ($contato == "7-ERRO SISTEMA")
	{
		$statuscode = "15";
	}
	else if ($contato == "8-VENDEDOR")
	{	
		$statuscode = "13";
	}
	else if ($contato == "9-TELEFONIA")
	{
		$statuscode = "24,25";
	}
}
else if($campanha == "HOTLINE")
{
	if($origem == "CLARO BRASIL COM CABO")
	{
		$statuscode = "2,7,8,9,10,11";
	}
	else
	{
		$statuscode = "2,7,8,9,10";
	}
}
else if ($campanha == "MUDANCA DE ENDERECO")
{
	if($contato == "1-ATENDIMENTO COM SUCESSO")
	{
		$statuscode = "26,27";
	}
}
else if ($campanha == "TRANSFERENCIA DE TITULARIDADE")
{
	if($contato == "1-ATENDIMENTO COM SUCESSO")
	{
		$statuscode = "28,29";
	}
}


$sql = "SELECT '0' [STATUSCODE], 'SELECIONE:' [STATUSTEXT] UNION ALL
		SELECT STATUSCODE, STATUSTEXT 
		FROM HOTLINE_STATUS_ATENDIMENTO_V5 /*HOTLINE_STATUS_ATENDIMENTO_V5 HOTLINE_STATUS_ATENDIMENTO_DEV*/
		WHERE StatusDetail = 0 AND
		STATUSCODE IN (".$statuscode.") 
		ORDER BY STATUSCODE"; 

$res = mssql_query($sql);
$num_status = mssql_num_rows($res);

for($j=0;$j<$num_status;$j++){
	$dados = mssql_fetch_array($res);
	$status= "<option value='".$dados['STATUSCODE']."-".$dados['STATUSTEXT']."'>".$dados['STATUSTEXT']."</option>";
	echo utf8_encode($status);
}

?>
