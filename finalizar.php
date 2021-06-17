<?php 
    session_start();
    if($_SESSION['nome'] == "" && $_SESSION['sobrenome'] == "")
    {
        $_SESSION['expirado'] = 1;
        header('location:index.php');
    }

    include "conexao_customer_huawei.php";
    $numAtendimento = $_POST['numAtendimento'];
    $nome = $_SESSION['nome']." ".$_SESSION['sobrenome'];
    $sql = "SELECT [tx_Numero_Atendimento] [INDICE], 
    cb_Canal_Vendas, 
    tx_nome,
    tx_login,
    tx_CPF_CNPJ,
    cb_contrato_proposta,
    tx_contrato,
    tx_ocorrencia_criada,
    cb_Modalidade_Atendimento,
    cb_Estado,
    cb_cidade,
    tx_loja_vendedor,
    cb_Campanha,
    cb_Realizara_Reserva_Telefonica,
    cb_Cadastrar_Empacotados,
    cb_End_Cobranc_Dif_Inst,
    cb_Incluir_Port_Tel_Fixo,
    tx_observacao

    FROM [CUSTOMER_NCM].[dbo].[CUSTOMER_HUAWEI_HOTLINE] WITH(NOLOCK) 
    WHERE TX_NUMERO_ATENDIMENTO = '".$numAtendimento."'"; 

    $res = mssql_query($sql);
    $qtd_atendimento = mssql_num_rows($res);

    if($qtd_atendimento == 0)
    {
        $novoAtendimento = 1;
    }
    else
    {
        $novoAtendimento = 0;
        $dados = mssql_fetch_array($res);
        $indice= utf8_decode($dados['INDICE']);	
        $canVendas = utf8_decode($dados['cb_Canal_Vendas']);
        $nomVendedor = utf8_decode($dados['tx_nome']);
        $logVendedor = utf8_decode($dados['tx_login']);
        $cpfCnpj = utf8_decode($dados['tx_CPF_CNPJ']);
        $opcContratoProposta = utf8_decode($dados['cb_contrato_proposta']);
        $conProposta = utf8_decode($dados['tx_contrato']);
        $ocoCriada = utf8_decode($dados['tx_ocorrencia_criada']);
        $modAtendimento = utf8_decode($dados['cb_Modalidade_Atendimento']);
        $estado = utf8_decode($dados['cb_Estado']);
        $cidade = utf8_encode(utf8_decode($dados['cb_cidade']));
        $lojVendedor = utf8_decode($dados['tx_loja_vendedor']);
        $campanha = utf8_decode($dados['cb_Campanha']);
        $reservaTelefonica = utf8_encode($dados['cb_Realizara_Reserva_Telefonica']);
        $cadastrarEmpacotados = utf8_encode($dados['cb_Cadastrar_Empacotados']);
        $enderecoDiferente = utf8_encode($dados['cb_End_Cobranc_Dif_Inst']);
        $incluirPortabilidade = utf8_encode($dados['cb_Incluir_Port_Tel_Fixo']);
        $observacao = utf8_encode($dados['tx_observacao']);
    }
    $nome = $_SESSION['nome']." ".$_SESSION['sobrenome'];

?> 
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="img/Logo.ico">

        <title>Huawei</title>

        <link href="dist/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="ajax.js"></script>
        <script type="text/javascript" src="micoxAjax.js"></script>
        <!-- Custom styles for this template -->
        <link href="form-validation.css" rel="stylesheet">
    </head>
    <style>
    
        div.grupoMPLAY {
            width: 1020px;
            height: 420px;
            background: #f8f9fa;
            color:  #000000;
            padding: 20px;
            border: 5px solid #6c757d;
        }

    </style>
    <script>
        function habilitaCampos()
        {
            var campanha = document.getElementById('campanha').value;
            console.log(campanha);
            ajaxGet("carrega_estado.php?uf="+document.getElementById('estado').value, document.getElementById('estado'), true);
            ajaxGet("carrega_status_contato.php?campanha="+campanha, document.getElementById('staContatoAtendimento'), true);

            if(document.getElementById('novoAtendimento').value == 1)
            {
                document.getElementById('badgeNovo').style.display = "inline";
            }
            else
            {
                document.getElementById('badgeNovo').style.display = "none";
            }

            changeContatoAtendimemto();
            changeCampanha();
        }

        function changeCampanha()
        {
            var campanha = document.getElementById('campanha').value;
            if(campanha == "")
            {
                document.getElementById('campanhaMPLAY').style.display = "none";
            }
            else if (campanha == "HOTLINE")
            {
                document.getElementById('campanhaMPLAY').style.display = "none";
            }
            else if (campanha == "MPLAY")
            {
                document.getElementById('campanhaMPLAY').style.display = "inherit";
            }
            ajaxGet("carrega_status_contato.php?campanha="+campanha, document.getElementById('staContatoAtendimento'), true);
            carregaStatusAtendimento();
        }

        function changeEstado()
        {
            ajaxGet('carrega_cidade.php?uf='+document.getElementById('estado').value, document.getElementById('cidade'), true);
        }

        function changeOrigemAtendimento()
        {
            ajaxGet('carrega_status.php?origem='+document.getElementById('oriAtendimento').value+"&campanha="+document.getElementById('campanha').value+"&statusContato="+document.getElementById('staContatoAtendimento').value, document.getElementById('staAtendimento'), true);
        }

        function carregaStatusAtendimento()
        {
            var statusAtendimento = document.getElementById('staAtendimento').value;
            var origem = document.getElementById('oriAtendimento').value;
            var contratoProposta = document.getElementById('opcContratoProposta').value;
            var campanha = document.getElementById('campanha').value;

            ajaxGet('carrega_detalhe.php?status='+statusAtendimento+'&origem='+origem+'&conpro='+contratoProposta+'&campanha='+campanha, document.getElementById('detAtendimento'), true);
        }

        function changeContatoAtendimemto()
        {
            var contatoAtendiento = document.getElementById('staContatoAtendimento').value;
            var campanha = document.getElementById('campanha').value;

            if(contatoAtendiento == "1-ATENDIMENTO COM SUCESSO")
            {
                document.getElementById('row5').style.display = "inherit";
            }
            else
            {
                document.getElementById('row5').style.display = "none";
            } 
            changeOrigemAtendimento();
            
            if (contatoAtendiento != "1-ATENDIMENTO COM SUCESSO" && campanha == "MUDANCA DE ENDERECO")
            {
                document.getElementById('divstaAtendimento').style.display = "none";
                document.getElementById('divdetAtendimento').style.display = "none";
            }
            else if (contatoAtendiento != "1-ATENDIMENTO COM SUCESSO" && campanha == "TRANSFERENCIA DE TITULARIDADE")
            {
                document.getElementById('divstaAtendimento').style.display = "none";
                document.getElementById('divdetAtendimento').style.display = "none";
            }
            else
            {
                document.getElementById('divstaAtendimento').style.display = "inherit";
                document.getElementById('divdetAtendimento').style.display = "inherit";
            }
        }

        function changeStatusAtendimemto()
        {
            carregaStatusAtendimento();    
        }

        function changeOpcaoContratoProposta()
        {
            carregaStatusAtendimento(); 
        }

        function validaCampos()
        {
            String.prototype.trim  = function() {return this.replace(/^\s+|\s+$/g,"");}
            String.prototype.ltrim = function() {return this.replace(/^\s+/,"");}
            String.prototype.rtrim = function() {return this.replace(/\s+$/,"");}

            var msg = "";
            var origem = document.getElementById('oriAtendimento').value;
            var campanha = document.getElementById('campanha').value;
            var canalVendas = document.getElementById('canVendas').value;
            var nomeVendedor = document.getElementById('nomVendedor').value;
            var loginVendedor = document.getElementById('logVendedor').value;
            var cpfCnpj = document.getElementById('cpfCnpj').value;
            var opcaoContratoProposta = document.getElementById('opcContratoProposta').value;
            var contratoProposta = document.getElementById('conProposta').value;
            var ocorrenciaCriada = document.getElementById('ocoCriada').value;
            var modalidadeAtendimento = document.getElementById('modAtendimento').value;
            var estado = document.getElementById('estado').value;
            var cidade = document.getElementById('cidade').value;
            var lojaVendedor = document.getElementById('lojVendedor').value;
            var vendedorAceitou = document.getElementById('venAceitou').value;
            var statusContatoAtendimento = document.getElementById('staContatoAtendimento').value;
            var statusAtendimento = document.getElementById('staAtendimento').value;
            var detalheAtendimento = document.getElementById('detAtendimento').value;

            var pendencias = [
                [document.getElementById('ckAlteracaoVendedor').value, document.getElementById('ckAlteracaoVendedor').checked],
                [document.getElementById('ckCombateConcorrencia').value, document.getElementById('ckCombateConcorrencia').checked],
                [document.getElementById('ckCreditoExterno').value, document.getElementById('ckCreditoExterno').checked],
                [document.getElementById('ckDesconectadoReinstalacao').value, document.getElementById('ckDesconectadoReinstalacao').checked],
                [document.getElementById('ckDuplicidadeCPF').value, document.getElementById('ckDuplicidadeCPF').checked],
                
                [document.getElementById('ckDuplicidadeProposta').value, document.getElementById('ckDuplicidadeProposta').checked],
                [document.getElementById('ckEnderecoDesabilitado').value, document.getElementById('ckEnderecoDesabilitado').checked],
                [document.getElementById('ckEnderecoAnalise').value, document.getElementById('ckEnderecoAnalise').checked],
                [document.getElementById('ckEnderecoExistente').value, document.getElementById('ckEnderecoExistente').checked],
                [document.getElementById('ckEnderecoExistenteF_SLA').value, document.getElementById('ckEnderecoExistenteF_SLA').checked],

                [document.getElementById('ckEnderecoInadimplente').value, document.getElementById('ckEnderecoInadimplente').checked],
                [document.getElementById('ckOutrosEndereco').value, document.getElementById('ckOutrosEndereco').checked],
                [document.getElementById('ckPerfilxProduto').value, document.getElementById('ckPerfilxProduto').checked],
                [document.getElementById('ckPreferidosClaro').value, document.getElementById('ckPreferidosClaro').checked],
                [document.getElementById('ckProblemasSPC').value, document.getElementById('ckProblemasSPC').checked],

                [document.getElementById('ckReservaPortTelFix').value, document.getElementById('ckReservaPortTelFix').checked],
                [document.getElementById('ckReservaTelefonica').value, document.getElementById('ckReservaTelefonica').checked],
                [document.getElementById('ckSolicOperador').value, document.getElementById('ckSolicOperador').checked],
                [document.getElementById('ckVistoriaEndereco').value, document.getElementById('ckVistoriaEndereco').checked],
                [document.getElementById('ckCadastrarEmpacotados').value, document.getElementById('ckCadastrarEmpacotados').checked],
            ];
        
        
            var realizadaReservaTelefonica = document.getElementById('reservaTelefonica').value;
            var cadastrarEmpacotados = document.getElementById('cadastrarEmpacotados').value;
            var enderecoCobrancaDiferente = document.getElementById('enderecoDiferente').value;
            var incluirPortabilidade = document.getElementById('incluirPortabilidade').value;


            if(origem == "" || origem == "SELECIONE:")
            {
                msg += "Selecione o campo 'Origem do Atendimento:'!\n"
            }

            if(campanha == "" || campanha == "SELECIONE:")
            {
                msg += "Selecione o campo 'Campanha:'!\n"
            }

            if(canalVendas.trim() == "")
            {
                msg += "Preencha o campo 'Canal de Vendas:'!\n"
            }
            
            if(nomeVendedor.trim() == "")
            {
                msg += "Preencha o campo 'Nome Vendedor:'!\n"
            }

            if(loginVendedor.trim() == "")
            {
                msg += "Preencha o campo 'Login Vendedor:'!\n"
            }

            if(cpfCnpj.trim() == "")
            {
                msg += "Preencha o campo 'CPF/CNPJ:'!\n"
            }
            else if(cpfCnpj.length == 10 || cpfCnpj.length == 11)
            {
                var cpf = cpfCnpj;
                if(cpf.length == 10)
                {
                    cpf = '0' + cpf;
                }
                if (cpf.length != 11     || cpf == ''    ||
                cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || 
                cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || 
                cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" ||  
                cpf == "99999999999" || cpf == "12345678901") 
                {
                    msg += "1.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
                } 
                else 
                {
                    soma = 0;
                    for(i = 0; i < 9; i++)
                    {
                        soma += parseInt(cpf.charAt(i)) * (10 - i);
                    }
                    resto = 11 - (soma % 11);
                
                    if(resto == 10 || resto == 11)
                    {
                        resto = 0;
                    }

                    if(resto != parseInt(cpf.charAt(9))) 
                    {
                        msg += "2.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
                    } 
                    else 
                    {
                        soma = 0;

                        for(i = 0; i < 10; i ++)
                        {
                            soma += parseInt(cpf.charAt(i)) * (11 - i);
                        }

                        resto = 11 - (soma % 11);

                        if(resto == 10 || resto == 11)
                        {
                            resto = 0;
                        }

                        if(resto != parseInt(cpf.charAt(10))) 
                        {
                            msg += "3.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
                        }
                    }
                }
            }
            else if(cpfCnpj.length == 13 || cpfCnpj.length == 14)
            {        
                cnpj = cpfCnpj.replace(/[^\d]+/g,'');
            
                if (cnpj == "00000000000000" || 
                cnpj == "11111111111111" || 
                cnpj == "22222222222222" || 
                cnpj == "33333333333333" || 
                cnpj == "44444444444444" || 
                cnpj == "55555555555555" || 
                cnpj == "66666666666666" || 
                cnpj == "77777777777777" || 
                cnpj == "88888888888888" || 
                cnpj == "99999999999999") 
                {
                    msg += "4.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
                } 
                else 
                {
                    tamanho = cnpj.length - 2
                    numeros = cnpj.substring(0,tamanho);
                    digitos = cnpj.substring(tamanho);
                    soma = 0;
                    pos = tamanho - 7;
                    for (i = tamanho; i >= 1; i--) 
                    {
                        soma += numeros.charAt(tamanho - i) * pos--;
                        if (pos < 2)
                        pos = 9;
                    }
                    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                
                    if (resultado != digitos.charAt(0)) 
                    {
                        msg += "5.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
                    } 
                    else 
                    {			
                        tamanho = tamanho + 1;
                        numeros = cnpj.substring(0,tamanho);
                        soma = 0;
                        pos = tamanho - 7;
                        for (i = tamanho; i >= 1; i--) 
                        {
                            soma += numeros.charAt(tamanho - i) * pos--;
                            if (pos < 2)
                                pos = 9;
                        }
                        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                        if (resultado != digitos.charAt(1)) 
                        {
                            msg += "6.Preencha o campo 'CPF/CNPJ:' corretamente!\n";
                        }           
                    }
                }
            }

            if (opcaoContratoProposta == "" || opcaoContratoProposta == "SELECIONE:")
            {
                msg += "Selecione o campo 'Opção Contrato ou Proposta:'!\n";
            }

            if (contratoProposta.trim() == "")
            {
                msg += "Preencha o campo 'Contrato/Proposta:'!\n";
            }
            else if(isNaN(contratoProposta))
            {
                msg += "1.Preencha o campo 'Contrato/Proposta:' somente com valores numéricos!\n";
            }
            else if(contratoProposta.indexOf("e") > -1 || contratoProposta.indexOf("E") > -1 || contratoProposta.indexOf(".") > -1 )
            {
                msg += "2.Preencha o campo 'Contrato/Proposta:' somente com valores numéricos!\n";
            }

            if (ocorrenciaCriada.trim() == "")
            {
                msg += "Preencha o campo 'Ocorrência Criada:'!\n";
            }

            if (modalidadeAtendimento == "" || modalidadeAtendimento == "SELECIONE:")
            {
                msg += "Selecione o campo 'Modalidade Atendimento:'!\n";
            }

            if (estado == "" || estado == "SELECIONE:")
            {
                msg += "Selecione o campo 'Estado:'!\n";
            }

            if (cidade == "" || cidade == "SELECIONE:")
            {
                msg += "Selecione o campo 'Cidade:'!\n";
            }

            if (lojaVendedor.trim() == "")
            {
                msg += "Preencha o campo 'Loja Vendedor:'!\n";
            }

            if((vendedorAceitou.trim() == "" || vendedorAceitou == "SELECIONE:") && statusContatoAtendimento =="1-ATENDIMENTO COM SUCESSO")
            {
                msg += "Selecione o campo 'Vendedor aceitou responder à pesquisa de satisfação?'!\n";
            }

            if (statusContatoAtendimento == "" || statusContatoAtendimento == "0-SELECIONE:" || statusContatoAtendimento == "0")
            {
                msg += "Selecione o campo 'Status do Atendimento:'!\n";
            }

            if(campanha == "MUDANCA DE ENDERECO" || campanha == "TRANSFERENCIA DE TITULARIDADE")
            {
                if(statusContatoAtendimento == "1-ATENDIMENTO COM SUCESSO")
                {
                    if (statusAtendimento == "" || statusAtendimento == "0" || statusAtendimento == "0-SELECIONE:")
                    {
                        msg += "Selecione o campo 'Defina os atendimentos realizados nesta ligação:'!\n";
                    }

                    if (detalheAtendimento == "" || detalheAtendimento == "0" || detalheAtendimento == "0-SELECIONE:")
                    {
                        msg += "Selecione o campo 'Detalhe do Atendimento:'!\n";
                    }
                }
            }
            else if (campanha == "MPLAY")
            {
                if (statusAtendimento == "" || statusAtendimento == "0" || statusAtendimento == "0-SELECIONE:")
                {
                    msg += "Selecione o campo 'Defina os atendimentos realizados nesta ligação:'!\n";
                }
                else if (statusContatoAtendimento != "8-VENDEDOR" && statusContatoAtendimento != "9-TELEFONIA")
                {
                    if (detalheAtendimento == "" || detalheAtendimento == "0" || detalheAtendimento == "0-SELECIONE:")
                    {
                        msg += "Selecione o campo 'Detalhe do Atendimento:'!\n";
                    }
                }
            }
            else
            {
                if (statusAtendimento == "" || statusAtendimento == "0" || statusAtendimento == "0-SELECIONE:")
                {
                    msg += "Selecione o campo 'Defina os atendimentos realizados nesta ligação:'!\n";
                }

                if (detalheAtendimento == "" || detalheAtendimento == "0" || detalheAtendimento == "0-SELECIONE:")
                {
                    msg += "Selecione o campo 'Detalhe do Atendimento:'!\n";
                }
            }

            if(campanha == "MPLAY")
            {
                if(statusAtendimento=="16-LIBERADA")
                {
                    var cont="";
                    var qtdck = pendencias.length;
                    var qtdPendCk = 0;
                    for(cont = 0; cont < qtdck; cont++)
                    {
                        if(pendencias[cont][1] == true)
                        {
                            qtdPendCk++;
                        }
                    }

                    if(qtdPendCk == 0)
                    {
                        msg += "Selecione ao menos um check box na lista de pendencias'!\n";
                    }

                    if(realizadaReservaTelefonica == "" || realizadaReservaTelefonica == "SELECIONE:")
                    {
                        msg += "Selecione o campo 'Realizada Reserva Telefonica:'!\n";
                    }

                    if(cadastrarEmpacotados == "" || cadastrarEmpacotados == "SELECIONE:")
                    {
                        msg += "Selecione o campo 'Cadastrar Empacotados:'!\n";
                    }

                    if(enderecoCobrancaDiferente == "" || enderecoCobrancaDiferente == "SELECIONE:")
                    {
                        msg += "Selecione o campo 'Endereço de Cobrança diferente da Instalação:'!\n";
                    }

                    if(incluirPortabilidade == "" || incluirPortabilidade == "SELECIONE:")
                    {
                        msg += "Selecione o campo 'Incluir Portabilidade de Tel. Fixo:'!\n";
                    }
                }
            }

            if(msg)
            {
                alert(msg);
            }
            else
            {
                finalizarHuawei.submit();
            }
        }
    </script>
    <body class="bg-light" onload="habilitaCampos();">
        <form name="finalizarHuawei" id="finalizarHuawei" method="post" action="salvar.php" onKeyUp= "" enctype="multipart/form-data">
            <div class="container">
                <div class="py-3 text-center">
                    <img class="mb-4" src="img/Logo.ico" alt="" width="56" height="56">
                    <h2>Huawei Formulário</h2>
                </div>
                <div class="row">      
                    <div class="col-md-12 order-md-1">
                        <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="username">Número do Atendimento: <b> <?php echo $_POST['numAtendimento'];?> </b> <span id="badgeNovo" class="badge badge-info">Novo</span></label>
                                    <input type="hidden"  id="novoAtendimento" name="novoAtendimento" value="<?php echo $novoAtendimento; ?>">
                                    <input type="hidden"  id="numAtendimento" name="numAtendimento" value="<?php echo $numAtendimento; ?>">
                                </div>
                                <div class="col-md-2 mb-3">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="oriAtendimento">Origem do Atendimento:</label>
                                    <select class="custom-select d-block w-100" id="oriAtendimento" name="oriAtendimento"  onchange="changeOrigemAtendimento();" required>
                                        <option value="" selected>SELECIONE:</option>
                                        <option value="CLARO BRASIL SEM CABO">CLARO BRASIL SEM CABO</option>
                                        <option value="CLARO BRASIL COM CABO">CLARO BRASIL COM CABO</option>
                                    </select>
                                    <div class="invalid-feedback">Selecione Origem do Atendimento</div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="campanha">Campanha:</label>
                                        <select class="custom-select d-block w-100" id="campanha" name="campanha"  onchange="changeCampanha();" required>
                                            <option value="" selected>SELECIONE:</option>
                                            <option value="HOTLINE">HOTLINE</option>
                                            <option value="MPLAY">MPLAY</option>
                                            <option value="MUDANCA DE ENDERECO">MUDANÇA DE ENDEREÇO</option>
                                            <option value="TRANSFERENCIA DE TITULARIDADE">TRANSFERENCIA DE TITULARIDADE</option>
                                        </select>
                                        <div class="invalid-feedback">Selecione a Campanha</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <label for="canVendas">Canal de Vendas:</label>
                                        <input type="text" class="form-control" id="canVendas" name="canVendas" value="<?php echo $canVendas; ?>" required>
                                        <div class="invalid-feedback">Informe o Canal de Vendas</div>
                                    </div>
                                    
                                    <div class="col-md-5 mb-3">
                                        <label for="nomVendedor">Nome Vendedor:</label>
                                        <input type="text" class="form-control" id="nomVendedor" name="nomVendedor" value="<?php echo $nomVendedor; ?>" required>
                                        <div class="invalid-feedback">Informe o Nome do Vendedor</div>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="logVendedor">Login Vendedor:</label>
                                        <input type="text" class="form-control" id="logVendedor" name="logVendedor" value="<?php echo $logVendedor; ?>" required>
                                        <div class="invalid-feedback">Informe o Login Vendedor</div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="cpfCnpj">CPF/CNPJ:</label>
                                        <input type="text" class="form-control" id="cpfCnpj" name="cpfCnpj" value="<?php echo $cpfCnpj; ?>" required>
                                        <div class="invalid-feedback">Informe o CPF ou CNPJ</div>
                                    </div>
                                </div>  

                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="opcContratoProposta">Opção Contrato ou Proposta:</label>
                                        <select class="custom-select d-block w-100" id="opcContratoProposta" name="opcContratoProposta" onchange="changeOpcaoContratoProposta();" required>
                                            <option value="<?php if($opcContratoProposta != "" ){echo $opcContratoProposta;}else {echo '';} ?>" selected><?php if($opcContratoProposta != "" ){echo $opcContratoProposta;}else {echo 'SELECIONE:';} ?></option>
                                            <option value="CONTRATO">CONTRATO</option>
                                            <option value="PROPOSTA">PROPOSTA</option>
                                        </select>
                                        <div class="invalid-feedback">Selecione Contrato ou Proposta</div>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="conProposta">Contrato/Proposta:</label>
                                        <input type="text" class="form-control" id="conProposta" name="conProposta"  value="<?php echo $conProposta; ?>" required>
                                        <div class="invalid-feedback">Informe o Contrato/Proposta</div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="ocoCriada">Ocorrência Criada:</label>
                                        <input type="text" class="form-control" id="ocoCriada" name="ocoCriada" value="<?php echo $ocoCriada; ?>" required>
                                        <div class="invalid-feedback">Informe a Ocorrência</div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="modAtendimento">Modalidade Atendimento:</label>
                                        <select class="custom-select d-block w-100" id="modAtendimento" name="modAtendimento" required>
                                            <option value="<?php if($modAtendimento != "" ){echo $modAtendimento;}else {echo '';} ?>" selected><?php if($modAtendimento != "" ){echo $modAtendimento;}else {echo 'SELECIONE:';} ?></option>
                                            <option value="PME">PME</option>
                                            <option value="INDIVIDUAL">INDIVIDUAL</option>
                                            <option value="COLETIVO">COLETIVO</option>
                                        </select>
                                        <div class="invalid-feedback">Selecione Modalidade do Atendimento</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mb-3">
                                        <label for="estado">Estado:</label>
                                        <select class="custom-select d-block w-100" id="estado" name="estado"  onchange="changeEstado();" required>
                                            <option value="<?php if($estado != "" ){echo $estado;}else {echo '';} ?>" selected><?php if($estado != "" ){echo $estado;}else {echo 'SELECIONE:';} ?></option>
                                        </select>
                                        <div class="invalid-feedback">Selecione Estado</div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="cidade">Cidade:</label>
                                        <select class="custom-select d-block w-100" id="cidade" name="cidade" required>
                                            <option value="<?php if($cidade != "" ){echo $cidade;}else {echo '';} ?>" selected><?php if($cidade != "" ){echo $cidade;}else {echo 'SELECIONE:';} ?></option>
                                        </select>
                                        <div class="invalid-feedback">Selecione Cidade</div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="lojVendedor">Loja Vendedor:</label>
                                        <input type="text" class="form-control" id="lojVendedor" name="lojVendedor" value="<?php echo $lojVendedor; ?>" required>
                                        <div class="invalid-feedback">Informe a Loja do Vendedor</div>
                                    </div>
                                </div>

                                <div class="row" id="row5" name="row5">
                                    <div class="col-md-6 mb-3">
                                        <label for="venAceitou">Vendedor aceitou responder à pesquisa de satisfação?</label>
                                        <select class="custom-select d-block w-100" id="venAceitou" name="venAceitou">
                                            <option value="SELECIONE:">SELECIONE:</option>
                                            <option value="SIM">SIM</option>
                                            <option value="NÃO">NÃO</option>
                                        </select>
                                    <div class="invalid-feedback">Selecione se aceitou responder à pesquisa de satisfação?</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="staContatoAtendimento">Status do Atendimento:</label>
                                    <select class="custom-select d-block w-100" id="staContatoAtendimento" name="staContatoAtendimento" onchange="changeContatoAtendimemto();" required>
                                        <option value="SELECIONE:" selected>SELECIONE:</option>
                                    </select>
                                    <div class="invalid-feedback">Selecione Status do Atendimento</div>
                                </div>

                                <div class="col-md-5 mb-3">
                                    <div id="divstaAtendimento" name="divstaAtendimento">
                                        <label for="staAtendimento">Defina os atendimentos realizados nesta ligação:</label>
                                        <select class="custom-select d-block w-100" id="staAtendimento" name="staAtendimento" onchange="changeStatusAtendimemto();" required>
                                            <option value="SELECIONE:" selected>SELECIONE:</option>
                                        </select>
                                        <div class="invalid-feedback">Selecione atendimento realizado nesta ligação</div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div id="divdetAtendimento" name="divdetAtendimento">
                                        <label for="detAtendimento">Detalhe do Atendimento:</label>
                                        <select class="custom-select d-block w-100" id="detAtendimento" name="detAtendimento" required>
                                            <option value="SELECIONE:" selected>SELECIONE:</option>
                                        </select>
                                        <div class="invalid-feedback">Selecione detalhe do atendimento</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <?php 	
                                    /*
                                    while ($row = mssql_fetch_array($protocolos_encontrados))
                                    {                                                  
                                        echo "
                                        <tr>
                                            <td>
                                                <div class='col-md-4 col-xs-4'>
                                                    <a class='btn btn-primary btn-block' href='".$site."' role='button'>".utf8_encode($row['Protocolo'])."</a>
                                                </div>
                                                <div class='col-md-4 col-xs-4'>										
                                                </div>
                                                <div class='col-md-4 col-xs-4'>
                                                </div>									
                                            </td>
                                        
                                            <td>".utf8_encode($dias)."</td>
                                            <td>
                                                <div class='col-md-4 col-xs-4' style='".$classificacao."'>
                                                    <h2></h2>
                                                </div>
                                                <div class='col-md-4 col-xs-4'>										
                                                </div>
                                                <div class='col-md-4 col-xs-4' >
                                                </div>									
                                            </td>
                                        </tr>								
                                        ";								
                                    }	*/                  
                                ?>
                            </div>
                            <div class="row" id="campanhaMPLAY" name="campanhaMPLAY">
                                <label for="pendencias">Pendencias:</label>
                                <div class="grupoMPLAY" style="float: left" id="pendencias" name="pendencias">
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="checkbox"  id="ckAlteracaoVendedor" name="ckAlteracaoVendedor" value="Alteracao do Vendedor" >Alteracao do Vendedor<br>
                                            <input type="checkbox"  id="ckCombateConcorrencia" name="ckCombateConcorrencia" value="Combate a Concorrencia" >Combate a Concorrencia<br>
                                            <input type="checkbox"  id="ckCreditoExterno" name="ckCreditoExterno" value="Credito Externo" >Credito Externo<br>
                                            <input type="checkbox"  id="ckDesconectadoReinstalacao" name="ckDesconectadoReinstalacao" value="Desconectado Reinstalação" >Desconectado Reinstalação<br>
                                            <input type="checkbox"  id="ckDuplicidadeCPF" name="ckDuplicidadeCPF" value="Duplicidade de CPF/CNPJ" >Duplicidade de CPF/CNPJ<br>

                                            <input type="checkbox"  id="ckDuplicidadeProposta" name="ckDuplicidadeProposta" value="Duplicidade de Proposta" >Duplicidade de Proposta<br>
                                            <input type="checkbox"  id="ckEnderecoDesabilitado" name="ckEnderecoDesabilitado" value="Endereço Desabilitado" >Endereço Desabilitado<br>
                                            <input type="checkbox"  id="ckEnderecoAnalise" name="ckEnderecoAnalise" value="Endereço em Analise" >Endereço em Analise<br>
                                            <input type="checkbox"  id="ckEnderecoExistente" name="ckEnderecoExistente" value="Endereço Existente" >Endereço Existente<br>
                                            <input type="checkbox"  id="ckEnderecoExistenteF_SLA" name="ckEnderecoExistenteF_SLA" value="Endereço Existente - Fora SLA" >Endereço Existente - Fora SLA
                                        </div>
                    
                                    <div class="col-4">
                                        <input type="checkbox"  id="ckEnderecoInadimplente" name="ckEnderecoInadimplente" value="Endereço Inadimplente" >Endereço Inadimplente<br>
                                        <input type="checkbox"  id="ckOutrosEndereco" name="ckOutrosEndereco" value="Outros Endereço" >Outros Endereço<br>
                                        <input type="checkbox"  id="ckPerfilxProduto" name="ckPerfilxProduto" value="Perfil x Produto" >Perfil x Produto<br>
                                        <input type="checkbox"  id="ckPreferidosClaro" name="ckPreferidosClaro" value=">Preferidos Claro" >Preferidos Claro<br>
                                        <input type="checkbox"  id="ckProblemasSPC" name="ckProblemasSPC" value="Problemas SPC" >Problemas SPC<br>

                                        <input type="checkbox"  id="ckReservaPortTelFix" name="ckReservaPortTelFix" value="Reserva Portabilidade Tel Fix." >Reserva Portabilidade Tel Fix.<br>
                                        <input type="checkbox"  id="ckReservaTelefonica" name="ckReservaTelefonica" value="Reserva Telefonica" >Reserva Telefonica<br>
                                        <input type="checkbox"  id="ckSolicOperador" name="ckSolicOperador" value="Solicitada pelo Operador" >Solicitada pelo Operador<br>
                                        <input type="checkbox"  id="ckVistoriaEndereco" name="ckVistoriaEndereco" value="Vistoria de Endereço" >Vistoria de Endereço<br>
                                        <input type="checkbox"  id="ckCadastrarEmpacotados" name="ckCadastrarEmpacotados" value="Cadastrar Empacotados" >Cadastrar Empacotados
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <label for="reservaTelefonica">Realizada Reserva Telefonica:</label>
                                            <select class="custom-select d-block w-100" id="reservaTelefonica" name="reservaTelefonica">
                                                <option value="<?php if($reservaTelefonica != "" ){echo $reservaTelefonica;}else {echo '';} ?>" selected><?php if($reservaTelefonica != "" ){echo $reservaTelefonica;}else {echo 'SELECIONE:';} ?></option>
                                                <option value="SIM">SIM</option>
                                                <option value="NÃO">NÃO</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <label for="cadastrarEmpacotados">Cadastrar Empacotados:</label>
                                            <select class="custom-select d-block w-100" id="cadastrarEmpacotados" name="cadastrarEmpacotados">
                                                <option value="<?php if($cadastrarEmpacotados != "" ){echo $cadastrarEmpacotados;}else {echo '';} ?>" selected><?php if($cadastrarEmpacotados != "" ){echo $cadastrarEmpacotados;}else {echo 'SELECIONE:';} ?></option>
                                                <option value="SIM">SIM</option>
                                                <option value="NÃO">NÃO</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <label for="enderecoDiferente">Endereço de Cobrança diferente da Instalação:</label>
                                            <select class="custom-select d-block w-100" id="enderecoDiferente" name="enderecoDiferente">
                                                <option value="<?php if($enderecoDiferente != "" ){echo $enderecoDiferente;}else {echo '';} ?>" selected><?php if($enderecoDiferente != "" ){echo $enderecoDiferente;}else {echo 'SELECIONE:';} ?></option>
                                                <option value="SIM">SIM</option>
                                                <option value="NÃO">NÃO</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <label for="incluirPortabilidade">Incluir Portabilidade de Tel. Fixo:</label>
                                            <select class="custom-select d-block w-100" id="incluirPortabilidade" name="incluirPortabilidade">
                                                <option value="<?php if($incluirPortabilidade != "" ){echo $incluirPortabilidade;}else {echo '';} ?>" selected><?php if($incluirPortabilidade != "" ){echo $incluirPortabilidade;}else {echo 'SELECIONE:';} ?></option>
                                                <option value="SIM">SIM</option>
                                                <option value="NÃO">NÃO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                      
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="txObservacao">Observação:</label>
                                        <input type="text" class="form-control" id="txObservacao" name="txObservacao" value="<?php echo $observacao; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mb-2">
                <button class="btn btn-primary btn-lg btn-block" type="button" onclick="validaCampos();">Finalizar Atendimento</button>
            </div>
        </form>
        

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
        <script src="../../assets/js/vendor/popper.min.js"></script>
        <script src="../../dist/js/bootstrap.min.js"></script>
        <script src="../../assets/js/vendor/holder.min.js"></script>
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function()
            {
                'use strict';
                window.addEventListener('load', function()
                {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');

                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form)
                    {
                        form.addEventListener('submit', function(event)
                        {
                            if (form.checkValidity() === false)
                            {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>
    </body>
    <footer class="my-4 pt-4 text-muted text-center text-small">
        <p class="mb-1">Operador: <b><?php echo $nome; ?></b></p>
        <p class="mb-1">&copy; 2020-2021 Motiva Contact Center</p>
    </footer>
</html>
