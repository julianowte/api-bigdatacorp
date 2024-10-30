<?php
require '../vendor/autoload.php';
/*
site for access:
    https://docs.bigdatacorp.com.br/plataforma/reference/autenticacao-e-seguranca

*/
define('BIGDATACORP_LOGIN', 'your_login');
define('BIGDATACORP_PASSWORD', 'your_password');

use Julianowte\ApiBigdatacorp\BigDataCorp;

//EXAMPLE
$timeToExpire = 24; //in hours to expire token;
$Bigdatacorp = new BigDataCorp();
$token = $Bigdatacorp->authBigDataCorp($timeToExpire);
var_dump($token);

echo "<br><br>";
//CONSULTA CPF/CNPJ
$cnpj_or_cpf = '00.000.000/0000-00';
$cpf_result = $Bigdatacorp->getCpfOrCnpj($cnpj_or_cpf);
var_dump($cpf_result);
