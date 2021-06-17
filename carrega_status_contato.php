<?php 

include "conexao_customer_huawei.php";
$campanha = $_GET['campanha'];

if($campanha == "MPLAY")
{	
	$sql = "SELECT 0 [STATUSCODE], 'SELECIONE:' [STATUSTEXT] UNION ALL
	SELECT STATUSCODE, STATUSTEXT 
	FROM [CUSTOMER_NCM].[dbo].[HOTLINE_STATUS_LIGACAO]
	WHERE 
	STATUSCODE IN (1,7,8,9)
	ORDER BY STATUSCODE"; 
}
else
{
	$sql = "SELECT 0 [STATUSCODE], 'SELECIONE:' [STATUSTEXT] UNION ALL
	SELECT STATUSCODE, STATUSTEXT 
	FROM [CUSTOMER_NCM].[dbo].[HOTLINE_STATUS_LIGACAO]
	WHERE 
	STATUSCODE IN (1,2,3,4,6)
	ORDER BY STATUSCODE"; 
}


$res = mssql_query($sql);
$num_status = mssql_num_rows($res);

for($j=0;$j<$num_status;$j++){
	$dados = mssql_fetch_array($res);
	$status= "<option value='".$dados['STATUSCODE']."-".$dados['STATUSTEXT']."'>".$dados['STATUSTEXT'] ."</option>";
echo utf8_encode($status);
}

?>
