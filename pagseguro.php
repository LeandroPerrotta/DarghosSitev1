<?
	
//DEFINE O LOGIN E SENHA PARA CONEXÃO COM O BANCO DE DADOS
$ConnLocal = "localhost:3309";
$ConnLogin = "root";
$ConnSenha = "W2e8EQaR";
$ConnDatabase = "pagseguro";

// CONECTA-SE COM O BANCO DE DADOS MySQL
$Conn = mysql_connect($ConnLocal, $ConnLogin, $ConnSenha) or print ('Não foi possível conectar<br />' . mysql_error());
$db2 = mysql_select_db($ConnDatabase, $Conn) or print(mysql_error());
	
// Aqui vai seu Token
define('TOKEN','808758EEEBA902A775FF533059E3A9B5');

// Função que captura os dados do retorno
function retorno_automatico 
( 
	$VendedorEmail, $TransacaoID, 
	$Referencia, $TipoFrete, $ValorFrete, $Anotacao, $DataTransacao,
	$TipoPagamento, $StatusTransacao, $CliNome, $CliEmail, 
	$CliEndereco, $CliNumero, $CliComplemento, $CliBairro, $CliCidade,
	$CliEstado, $CliCEP, $CliTelefone, $produtos, $NumItens
) 
{
	$descricao = explode(": ", $produtos[0]['ProdDescricao']);
	$ref_old = explode(": ", $Referencia);
	
	if(count($descricao) > 1)
	{	
		$periodo = $descricao[1];
	}
	else
	{
		if($produtos[0]['ProdDescricao'] == "1 mes (30 dias)")
			$periodo = "30";
		elseif($produtos[0]['ProdDescricao'] == "2 meses (60 dias)")
			$periodo = "60";
		elseif($produtos[0]['ProdDescricao'] == "3 meses (90 dias)")
			$periodo = "90";	
		elseif($produtos[0]['ProdDescricao'] == "6 meses (180 dias)")
			$periodo = "180";				
		elseif($produtos[0]['ProdDescricao'] == "1 ano (360 dias)")
			$periodo = "360";			
	}	
	
	if(count($ref_old) == 2)
		$Referencia = $ref_old[1];
	elseif(count($ref_old) == 3)
	{	
		$ref_old_acc = explode(" ", $ref_old[1]);	
		$acc_old = $ref_old_acc[0];
		
		$target_old = $ref_old[2];	
		
		$Referencia = "$target_old/$acc_old";
	}
	
	$dataTrans = explode(" ", $DataTransacao);	
	
	$data_d = explode("/", $dataTrans[0]);
	$data_h = explode(":", $dataTrans[1]);
	
	$dia = $data_d[0];
	$mes = $data_d[1];
	$ano = $data_d[2];
	
	$hora = $data_h[0];
	$min = $data_h[1];
	$seg = $data_h[2];
	
	$unix_data =  mktime($hora, $min, $seg, $mes, $dia, $ano);
	
	$trasação_query = mysql_query("SELECT id FROM pagsegurotransacoes WHERE TransacaoID = '".$TransacaoID."'");
	if(mysql_num_rows($trasação_query) == 0)
	{		
		mysql_query("INSERT INTO pagsegurotransacoes 
		(
			TransacaoID,
			Referencia,
			TipoPagamento,
			DataTransacao,
			ProdDescricao,
			ProdValor,
			StatusTransacao,
			CliNome,
			CliEmail,
			Anotacao
		) values 
		(
			'".$TransacaoID."',
			'".$Referencia."',
			'".$TipoPagamento."',
			'".$unix_data."',
			'".$periodo."',
			".$produtos[0]['ProdValor'].",
			'".$StatusTransacao."',
			'".$CliNome."',
			'".$CliEmail."',
			'".$Anotacao."'
		)") or (mysql_query("INSERT INTO errors ('".mysql_error()."'')"));	  
	
		if($StatusTransacao == "Aprovado")
		{
			//PAGAMENTO ONLINE, LIBERAÇÃO INSTANTANEA
		}	
	}
	else
	{
		mysql_query("UPDATE pagsegurotransacoes SET StatusTransacao = '".$StatusTransacao."' WHERE TransacaoID = '".$TransacaoID."'") or (mysql_query("INSERT INTO errors ('".mysql_error()."'')"));	
	
		if($StatusTransacao == "Aprovado")
		{
			//BOLETO CONFIRMADO, EFETUAR LIBERAÇÃO
		}		
	}	
}

// Incluindo o arquivo da biblioteca
include('retorno.php');

mysql_close($Conn); 
  
header ("Location: index.php?page=contribute.pagseguro"); 
?>
