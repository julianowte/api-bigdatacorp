<?php

namespace Julianowte\ApiBigdatacorp;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class BigDataCorp
{
    private string $BASE_ENDPOINT = 'https://plataforma.bigdatacorp.com.br';
    private string $TOKEN;
    private string $TOKEN_ID;

    public function __construct(
        private Client $client = new Client
    ) {
        $this->authBigDataCorp($timeToExpire = 24);
    }

    public function getCpfOrCnpj($str)
    {
        $str = preg_replace("/\D+/", '', $str);
        //cpf
        if (strlen($str) == 11) {
            return $this->getCpf($str);
        }
        if (strlen($str) == 14) {
            return $this->getCnpj($str);
        }
    }

    public function getCpf($cpf)
    {
        $url = $this->BASE_ENDPOINT . "/pessoas";
        $dados = [
            "q" => "doc{" . $cpf . "}",
            "Datasets" => "basic_data"
        ];

        try {
            $res = $this->client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    "AccessToken" => $this->TOKEN,
                    "TokenId" => $this->TOKEN_ID,
                    "Accept" => 'application/json'
                ],
                'body' => json_encode($dados)
            ]);
            $result = json_decode($res->getBody(), true);
            return json_encode([
                "data" => $result,
                "error" => []
            ]);
        } catch (RequestException $e) {
            $error['error'] = $e->getMessage();
            $error['request'] = Psr7\Message::toString($e->getRequest());
            if ($e->hasResponse()) {
                $error['response'] = Psr7\Message::toString($e->getResponse());
            }
            http_response_code(400);
            return json_encode([
                "data" => "",
                "error" => $error
            ]);
        }
    }

    public function getCnpj($cnpj)
    {
        $url = $this->BASE_ENDPOINT . "/empresas";
        $dados = [
            "q" => "doc{" . $cnpj . "}",
            "Datasets" => "basic_data"
        ];

        try {
            $res = $this->client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    "AccessToken" => $this->TOKEN,
                    "TokenId" => $this->TOKEN_ID,
                    "Accept" => 'application/json'
                ],
                'body' => json_encode($dados)
            ]);
            $result = json_decode($res->getBody(), true);
            return json_encode([
                "data" => $result,
                "error" => []
            ]);
        } catch (RequestException $e) {
            $error['error'] = $e->getMessage();
            $error['request'] = Psr7\Message::toString($e->getRequest());
            if ($e->hasResponse()) {
                $error['response'] = Psr7\Message::toString($e->getResponse());
            }
            http_response_code(400);
            return json_encode([
                "data" => "",
                "error" => $error
            ]);
        }
    }

    public function authBigDataCorp($timeToExpire)
    {
        $url = $this->BASE_ENDPOINT . "/tokens/gerar";
        $dados = [
            "login" => BIGDATACORP_LOGIN,
            "password" => BIGDATACORP_PASSWORD,
            "expires" => $timeToExpire
        ];

        try {
            $res = $this->client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    "Accept" => 'application/json'
                ],
                'body' => json_encode($dados)
            ]);
            $res = json_decode($res->getBody(), true);
            $this->TOKEN = $res["token"];
            $this->TOKEN_ID = $res["tokenID"];
            return json_encode([
                "data" => $res,
                "error" => []
            ]);
        } catch (RequestException $e) {
            $error['error'] = $e->getMessage();
            $error['request'] = Psr7\Message::toString($e->getRequest());
            if ($e->hasResponse()) {
                $error['response'] = Psr7\Message::toString($e->getResponse());
            }
            http_response_code(400);
            return json_encode([
                "token" => "",
                "error" => $error
            ]);
        }
    }
}
