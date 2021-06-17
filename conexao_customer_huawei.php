<?php

$conector = mssql_connect("10.100.0.72", "usr_desenvolvimento", "d3s3nv0lv1m3nt0ti01") or die("NÃO FOI POSSÍVEL A CONEXÃO COM O SERVIDOR");
$conn = mssql_select_db("CUSTOMER_NCM", $conector) or die("NÃO FOI POSSÍVEL SELECIONAR O BANCO DE DADOS");

?>