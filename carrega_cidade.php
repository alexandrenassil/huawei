<?php 

include "conexao_customer_huawei.php";
$uf = $_GET['uf'];
$sql = "SELECT '0'[COD], 'SELECIONE:' [CIDADE] UNION ALL SELECT '1' [COD], [CIDADE] FROM [CIDADES_UF] WHERE UF = '".$uf."' AND CIDADE <> '---------' ORDER BY COD, CIDADE"; 

$res = mssql_query($sql);
$num_cidade = mssql_num_rows($res);

for($j=0;$j<$num_cidade;$j++)
{
	$dados = mssql_fetch_array($res);
	$cidade= "<option value='".$dados['CIDADE']."'>".$dados['CIDADE'] ."</option>";
	echo utf8_encode($cidade);
}

?>
