<?php

$conector = mssql_connect("10.100.0.00", "usuario", "senha") or die("NÃO FOI POSSÍVEL A CONEXÃO COM O SERVIDOR");
$conn = mssql_select_db("CUSTOMER_NCM", $conector) or die("NÃO FOI POSSÍVEL SELECIONAR O BANCO DE DADOS");

?>
