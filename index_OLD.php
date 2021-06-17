<!doctype html>
<?php
	session_start();
	require 'conexao_customer_ocorrencia.php';
	$sql_customer = "SELECT  
	NOME_CLIENTE,
	CONTRATO, 
	ESTADO, 
	CIDADE,
	RUA,
	NUMERO_RESIDENCIAL,
	COMPLEMENTO,
	BAIRRO,
	PRODUTO,
	TELEFONE1,
	TELEFONE2,  
	TELEFONE3,
	OUTRO_TELEFONE,
	ID_OPERADOR,
	NOME_OPERADOR,
	NOME_SUPERVISOR,
	TRANSFERIDO_CANCELADO,
	RTRIM(LTRIM(REPLACE(STATUS_MAILING_3,'CALLFILE_BACKOFFICE.DBO.',''))) [CAMPANHA]
	
	FROM [OCORRENCIA_NACIONAL_CUSTOMER] WHERE INDICE = '".$_GET["indice"]."'";

	$indice_encontrado = mssql_query($sql_customer);
	while ($row_indice = mssql_fetch_array($indice_encontrado))
	{
		$nome_cliente = utf8_encode($row_indice['NOME_CLIENTE']);
		$contrato = utf8_encode($row_indice['CONTRATO']);
		$uf= utf8_encode($row_indice['ESTADO']);
		$cidade = utf8_encode($row_indice['CIDADE']);
		$rua = utf8_encode($row_indice['RUA']);
		$numero_residencial = utf8_encode($row_indice['NUMERO_RESIDENCIAL']);
		$complemento = utf8_encode($row_indice['COMPLEMENTO']);
		$bairro = utf8_encode($row_indice['BAIRRO']);
		$produto = utf8_encode($row_indice['PRODUTO']);
		$telefone1 = utf8_encode($row_indice['TELEFONE1']);
		$telefone2 = utf8_encode($row_indice['TELEFONE2']);
		$telefone3 = utf8_encode($row_indice['TELEFONE3']);
		$outro_telefone = utf8_encode($row_indice['OUTRO_TELEFONE']);
		$id_operador = utf8_encode($row_indice['ID_OPERADOR']);
		$operador = utf8_encode($row_indice['NOME_OPERADOR']);
		$supervisor = utf8_encode($row_indice['NOME_SUPERVISOR']);
		$campanha = utf8_encode($row_indice['CAMPANHA']);
		$canal_local = utf8_encode($row_indice['TRANSFERIDO_CANCELADO']);
	}
	
?>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">
		
		<!--
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-1.12.0.min.js"  integrity="sha256-Xxq2X+KtazgaGuA2cWR1v3jJsuMJUozyIXDB3e793L8="  crossorigin="anonymous"></script>
		-->

		<!--
		<script src="ajax/v3.3.1/jquery.min.js"></script>
		<script src="bootstrap/v3.4.1/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="bootstrap/v3.4.1/css/bootstrap.min.css"/>
		<script src="jquery/jquery-1.12.0.min.js"></script>
		-->

	
		<script src="http://10.100.0.99/net/acessos/jquery.min.js"></script>
		<script src="http://10.100.0.99/net/acessos/bootstrap 3.4.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="http://10.100.0.99/net/acessos/bootstrap 3.4.0/css/bootstrap.min.css">
		<script src="http://10.100.0.99/net/acessos/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="http://10.100.0.99/net/acessos/bootstrap-3.4.1-dist/css/bootstrap.min.css">

		<script src="http://10.100.0.99/net/acessos/jquery-1.12.0.min.js"  integrity="sha256-Xxq2X+KtazgaGuA2cWR1v3jJsuMJUozyIXDB3e793L8="  crossorigin="anonymous"></script>

    	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript" src="ajax.js"></script>
		<script type="text/javascript" src="micoxAjax.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" src="css/bootstrap.min.css"></script>
		<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.11.4.custom/jquery-ui.css"/>
		<script type="text/javascript" src="js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
		
		<style> 
			body,html {
				position: relative; 
				height: 100%;
  				margin: 0;
				width: 100%;
			}
			
			header, section, footer, aside, nav, main, article, figure 
			{
				display: block;
				position: relative;  
			}

			.sidebar {
			margin: 0;
			padding: 10;
			width: 300px;
			background-color: #f1f1f1;
			position: fixed;
			height: 75%;
			overflow: auto;
			right: 0;
			top: relative;
			}


			.sidebar a {
			display: block;
			color: black;
			padding: 16px;
			text-decoration: none;
			}
			
			.sidebar a.active {
			background-color: #4CAF50;
			color: white;
			}

			.sidebar a:hover:not(.active) {
			background-color: #555;
			color: white;
			}
						
			@media screen and (max-width: 700px) {
			.sidebar {
				width: 100%;
				height: auto;
				position: relative;
			}
			.sidebar a {float: left;}
			row {margin-left: 0;}
			}
						
			@media screen and (max-width: 400px) {
			.sidebar a {
				text-align: center;
				float: none;
			}
			
			}		

			.dropdown-submenu {
				position: relative;
			}

			.dropdown-submenu>.dropdown-menu {
				top: 0;
				left: 100%;
				margin-top: -6px;
				margin-left: -1px;
				-webkit-border-radius: 0 6px 6px 6px;
				-moz-border-radius: 0 6px 6px;
				border-radius: 0 6px 6px 6px;
			}

			.dropdown-submenu:hover>.dropdown-menu {
				display: block;
			}

			.dropdown-submenu>a:after {
				display: block;
				content: " ";
				float: right;
				width: 0;
				height: 0;
				border-color: transparent;
				border-style: solid;
				border-width: 5px 0 5px 5px;
				border-left-color: #ccc;
				margin-top: 5px;
				margin-right: -10px;
			}

			.dropdown-submenu:hover>a:after {
				border-left-color: #fff;
			}

			.dropdown-submenu.pull-left {
				float: none;
			}

			.dropdown-submenu.pull-left>.dropdown-menu {
				left: -100%;
				margin-left: 10px;
				-webkit-border-radius: 6px 0 6px 6px;
				-moz-border-radius: 6px 0 6px 6px;
				border-radius: 6px 0 6px 6px;
			}
			
		</style>

	<script>
		$(function() {
			$( "#datareagendada" ).datepicker({
			dateFormat: 'dd/mm/yy',
			dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
			dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
			dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
			monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
			nextText: 'Próximo',
			prevText: 'Anterior',
			minDate: "+0d"
			});
		});

		$(function() {
			$( "#dataagendamento" ).datepicker({
			dateFormat: 'dd/mm/yy',
			dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
			dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
			dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
			monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
			nextText: 'Próximo',
			prevText: 'Anterior',
			minDate: "+0d",
			maxDate: "+0d"
			});
		});	

		

		function blockBckSpc() 
		{

			function click() {
			if (event.button==2||event.button==3) {
				oncontextmenu='return false';
			}
			}

			function click2(e) {
			e = window.event;
			if (event.keyCode==8 &&( e.srcElement.type == undefined || e.srcElement.type == 'select-one' || e.srcElement.type == 'radio' || e.srcElement.readOnly == true)) {
				event.returnValue = false;
			}
			if (event.altKey==1) {event.returnValue = false;}
			}


			document.onmousedown = click;
			document.onkeydown = click2;

			document.oncontextmenu = new Function("return false;");

		}
		
		

		function habilita_campos()
		{
			
			ajaxGet("carrega_status.php?campanha="+document.getElementById('callfile').value, document.getElementById('cbStatusAtendimento'), true);
			
			ajaxGet("carrega_pausa.php", document.getElementById('cbtipopausa'), true);

			
			changeStatusAtendimento();
			blockBckSpc();		
		}
		
		
		
		function ValidaCampos()
		{
			String.prototype.trim  = function() {return this.replace(/^\s+|\s+$/g,"");}
			String.prototype.ltrim = function() {return this.replace(/^\s+/,"");}
			String.prototype.rtrim = function() {return this.replace(/\s+$/,"");}

			var msg = "t";


			
			if(msg)
			{
				alert(msg);
			}
			else
			{
				
				var SalvarRegistro = "cbStatusAtendimento_val="+status_atendimento_val+"&";
				SalvarRegistro += "cbStatusAtendimento="+status_atendimento+"&";
				SalvarRegistro += "cbDetalheAtendimento_val="+detalhe_atendimento_val+"&";
				SalvarRegistro += "cbDetalheAtendimento="+detalhe_atendimento+"&";
				SalvarRegistro += "datareagendada="+data_reagendada+"&";
				SalvarRegistro += "periodoreagendado="+periodo_reagendada+"&";
				SalvarRegistro += "novocontrato="+novocontrato+"&";
				SalvarRegistro += "novaproposta="+novaproposta+"&";
				SalvarRegistro += "numerochamado="+numerochamado+"&";
				SalvarRegistro += "numeroocorrencia="+numeroocorrencia+"&";
				SalvarRegistro += "protocolo="+protocolo+"&";
				SalvarRegistro += "cbenvioprotocolo="+cbenvioprotocolo+"&";

				SalvarRegistro += "checklistemail="+email+"&";
				SalvarRegistro += "checklisttelefonecelular="+checklisttelefonecelular+"&";
				SalvarRegistro += "outrotelefone="+outrotelefone+"&";
				SalvarRegistro += "indice="+indice;

				if(detalhe_atendimento_val == "0")
				{
					detalhe_atendimento = "";
				}

				var toolbar = "";
				if(status_atendimento_val == 94 || status_atendimento_val == 95)
				{
					var Data = document.getElementById('dataagendamento').value;
					var Hora = document.getElementById('horarioagendamento').value;
					toolbar = "finalizar|"+status_atendimento_val+"|"+detalhe_atendimento_val+"|"+Data+"|"+Hora+"|1102222222|"+tipopausa+"|"+pausa+"|"+login_super+"|"+senha_super;
				}
				else
				{
					toolbar = "finalizar|"+status_atendimento_val+"|"+detalhe_atendimento_val+"||||"+tipopausa+"|"+pausa+"|"+login_super+"|"+senha_super;
				}	
				
				$.ajax({
							url: "cadastrar.php",
							type: "POST",
							data: SalvarRegistro,
							dataType: "html"

						}).done(function(resposta) {
							if (resposta == "OK") {
								var mensagem = toolbar;
								/*
								alert(toolbar);
								alert(SalvarRegistro);
								*/
								window.parent.postMessage(mensagem, "*");
							}							

						});/*.fail(function(jqXHR, textStatus ) {
							console.log("Request failed: " + textStatus);

						}).always(function() {
							console.log("completou");
						});*/								
			}			
		}		

		function changeStatusAtendimento()
		{
			ajaxGet('carrega_detalhe.php?codStatus='+document.getElementById('cbStatusAtendimento').value+'&campanha='+document.getElementById('callfile').value, document.getElementById('cbDetalheAtendimento'), true);
			
			var statuscod = document.getElementById('cbStatusAtendimento').value;
					
		}		
				
	</script>
	</head>
	<body onload="habilita_campos();">
		<form name="finalizacaoHuawei" id="finalizacaoHuawei" enctype="multipart/form-data" method="post" action="" onKeyUp= "">			
			<div class="form-group">
				<label for="exampleFormControlInput1">Email address</label>
				<input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
			</div>
			<div class="form-group">
				<label for="exampleFormControlSelect1">Example select</label>
				<select class="form-control" id="exampleFormControlSelect1">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				</select>
			</div>
			<div class="form-group">
				<label for="exampleFormControlSelect2">Example multiple select</label>
				<select multiple class="form-control" id="exampleFormControlSelect2">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				</select>
			</div>
			<div class="form-group">
				<label for="exampleFormControlTextarea1">Example textarea</label>
				<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
			</div>
		</form>
	</body>
</html>