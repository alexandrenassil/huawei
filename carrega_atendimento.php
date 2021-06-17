<?php 

include "conexao_customer_huawei.php";
$numAtendimento = $_GET['numAtendimento'];
$sql = "SELECT INDICE, cb_Canal_Vendas FROM [CUSTOMER_NCM].[dbo].[CUSTOMER_HUAWEI_HOTLINE] WITH(NOLOCK) WHERE INDICE = '".$numAtendimento."'"; 

$res = mssql_query($sql);
$qtd_atendimento = mssql_num_rows($res);

for($j=0;$j<$qtd_atendimento;$j++)
{
	$dados = mssql_fetch_array($res);
	$indice= $dados['INDICE'];	
	$canalvendas = $dados['cb_Canal_Vendas'];
}

?>
