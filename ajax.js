/* Sistema desenvolvido por Franco V. Morales/MOTIVA CONTACT CENTER - Campinas 24ago15 */
/* Ultima alteração - Franco V. Morales - Campinas 24ago15 */

// JavaScript Document

function CarregaCidades(codEstado)
{

		var myAjax = new Ajax.Updater('cidade','carrega_cidades.php?codEstado='+codEstado,
		{
			method : 'get',
		}) ;

}

function CarregaCidadesClaro(codEstado)
{

		var myAjax = new Ajax.Updater('cidade','carrega_cidades_claro.php?codEstado='+codEstado,
		{
			method : 'get',
		}) ;

}


function CarregaTipoSolicitacao(solicitacao)
{

		var myAjax = new Ajax.Updater('tiposolicitacao','carrega_tipo_solicitacao.php?solicitacao='+solicitacao,
		{
			method : 'get',
		}) ;

}

function CarregaDetalhe(codStatus)
{

		var myAjax = new Ajax.Updater('cbDetalheAtendimento','carrega_detalhe.php?codStatus='+codStatus,
		{
			method : 'get',
		}) ;

}