<?php
require '../vendor/autoload.php';
/*
site for access:
    https://docs.bigdatacorp.com.br/plataforma/reference/autenticacao-e-seguranca

*/

use Julianowte\ApiBigdatacorp\BigDataCorp;


//ADD AQUI SUAS CREDENCIAIS DO BIGDATACORP
$bigdatacorp_login = 'xxxx';
$bigdatacorp_password = 'xxx';

$timeToExpire = 24; //in hours to expire token;
$dados_auth = [
    "login" => $bigdatacorp_login,
    "password" => $bigdatacorp_password,
    "time_to_expire" => $timeToExpire
];
$Bigdatacorp = new BigDataCorp();
$result = $Bigdatacorp->authBigDataCorp($dados_auth);
$result = json_decode($result, true);
//var_dump($result);

echo "<br><br>";
//CONSULTA CPF/CNPJ
//$cnpj_or_cpf = '19.505.135/0001-37';
$cnpj_or_cpf = '479.677.192-12';
$cpf_result = $Bigdatacorp->getCpfOrCnpj($cnpj_or_cpf, $result["token"], $result["token_id"]);
var_dump($cpf_result);
