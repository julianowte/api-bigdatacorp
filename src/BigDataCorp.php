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
    ) {}

    public function getCpfOrCnpj(string $str, string $_token = '', string $_token_id = ''): String
    {
        $str = preg_replace("/\D+/", '', $str);
        //cpf
        if (strlen($str) == 11) {
            return $this->getCpf($str, $_token, $_token_id);
        } else if (strlen($str) == 14) {
            return $this->getCnpj($str, $_token, $_token_id);
        } else {
            http_response_code(400);
            return json_encode([
                "data" => "",
                "error" => "CNPJ ou CPF invalido."
            ]);
        }
    }

    public function getCpf(string $cpf, string $_token = '', string $_token_id = ''): String
    {
        $url = $this->BASE_ENDPOINT . "/pessoas";
        $dados = [
            "q" => "doc{" . $cpf . "}",
            "Datasets" => "basic_data"
        ];

        $token = ($this->TOKEN ?? $_token);
        $token_id = ($this->TOKEN_ID ?? $_token_id);

        try {
            $res = $this->client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    "AccessToken" => $token,
                    "TokenId" => $token_id,
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

    public function getCnpj($cnpj, string $_token = '', string $_token_id = ''): String
    {
        $url = $this->BASE_ENDPOINT . "/empresas";
        $dados = [
            "q" => "doc{" . $cnpj . "}",
            "Datasets" => "basic_data"
        ];

        $token = ($this->TOKEN ?? $_token);
        $token_id = ($this->TOKEN_ID ?? $_token_id);

        try {
            $res = $this->client->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    "AccessToken" => $token,
                    "TokenId" => $token_id,
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

    public function authBigDataCorp(array $auth)
    {
        $url = $this->BASE_ENDPOINT . "/tokens/gerar";
        $dados = [
            "login" => $auth["login"],
            "password" => $auth["password"],
            "expires" => $auth["time_to_expire"]
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
                "token" => $res["token"],
                "token_id" => $res["tokenID"],
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
                "token_id" => "",
                "data" => "",
                "error" => $error
            ]);
        }
    }
}
