<?php 

include "conexao_customer_huawei.php";

$ufEncontrada = $_GET['uf'];
$sql = "SELECT '0'[COD], 'SELECIONE:' [UF] UNION ALL SELECT DISTINCT '1' [COD], [UF] FROM [CIDADES_UF] WHERE UF <> '---------' ORDER BY COD, UF"; 

$res = mssql_query($sql);
$num_uf = mssql_num_rows($res);

if($ufEncontrada)
{
	$uf= "<option value='".$ufEncontrada."'>".$ufEncontrada."</option>";
	echo utf8_encode($uf);
}

for($j=0;$j<$num_uf;$j++)
{
	$dados = mssql_fetch_array($res);
	$uf= "<option value='".$dados['UF']."'>".$dados['UF'] ."</option>";
	echo utf8_encode($uf);
}

?>
