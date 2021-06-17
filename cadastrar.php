<?php
    $status_atendimento_val = $_POST["cbStatusAtendimento_val"];
    $status_atendimento = utf8_decode($_POST["cbStatusAtendimento"]);
    $detalhe_atendimento_val = $_POST["cbDetalheAtendimento_val"];
    $detalhe_atendimento = utf8_decode($_POST["cbDetalheAtendimento"]);
    $data_reagendada = $_POST["datareagendada"];
    $periodo_reagendado = utf8_decode($_POST["periodoreagendado"]);
    $novo_contrato = $_POST["novocontrato"];
    $nova_proposta = $_POST["novaproposta"];
    $numero_chamado = $_POST["numerochamado"];
    $numero_ocorrencia = $_POST["numeroocorrencia"];
    $protocolo = $_POST["protocolo"];
    $envio_protocolo_val = $_POST["cbenvioprotocolo"];
    $envio_protocolo = $envio_protocolo_val;
    $indice = $_POST["indice"];
    $status_final = $_POST["cbStatusAtendimento"];
    $checklistemail = utf8_decode($_POST["checklistemail"]);
    $checklisttelefonecelular = $_POST["checklisttelefonecelular"];
    $outrotelefone = $_POST["outrotelefone"];

    if($detalhe_atendimento_val > 0)
    {
        $status_final .= " - ".$detalhe_atendimento;
    }

    $salvar_registro = "UPDATE A SET 
    [STATUS_ATENDIMENTO_VAL] = '".$status_atendimento_val."', 
    [STATUS_ATENDIMENTO] = '".$status_atendimento."', 
    [DETALHE_ATENDIMENTO_VAL] = '".$detalhe_atendimento_val."', 
    [DETALHE_ATENDIMENTO] = '".$detalhe_atendimento."', 
    [DATA_REAGENDADA] = '".$data_reagendada."',
    [PERIODO_REAGENDADO] = '".$periodo_reagendado."',
    [NOVO_CONTRATO] = '".$novo_contrato."',
    [NOVA_PROPOSTA] = '".$nova_proposta."',
    [NUMERO_CHAMADO] = '".$numero_chamado."',
    [NUMERO_OCORRENCIA] = '".$numero_ocorrencia."',
    [NUMERO_PROTOCOLO] = '".$protocolo."',
    [PROTOCOLO_ENVIADO_POR_VAL] = '".$envio_protocolo_val."',
    [PROTOCOLO_ENVIADO_POR] = '".$envio_protocolo."',
    [CHECKLIST_EMAIL] = '".$checklistemail."',
    [CHECKLIST_TELEFONE_CELULAR] = '".$checklisttelefonecelular."',
    [OUTRO_TELEFONE] = '".$outrotelefone."',
    [STATUS_FINAL] = '".$status_final."'

    FROM [OCORRENCIA_NACIONAL_CUSTOMER] A WHERE INDICE = '".$indice."'";
    require 'conexao_customer_ocorrencia.php';
    $resultado = mssql_query($salvar_registro);
    if ($resultado)
        echo "OK";
    else
        echo "NOK";

?>