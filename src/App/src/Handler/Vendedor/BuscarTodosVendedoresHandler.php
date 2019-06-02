<?php

declare(strict_types=1);

namespace App\Handler\Vendedor;

use Core\Handler\MainHandler;
use Core\Json\JsonException;
use Core\Json\JsonMessage;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Http\Client;
use Zend\Http\Request;


class BuscarTodosVendedoresHandler extends MainHandler
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        try {
            $token = $this->getHeader($request, 'token');

            $dataInicio = $this->getPost($request, 'data-inicio');
            $dataFim = $this->getPost($request, 'data-fim');

            $client = new Client();
            $client->setMethod(Request::METHOD_GET);
            $client->setUri('http://127.0.0.1/api/vendedor');
            $client->setHeaders([
                'token' => $token
            ]);
            $client->setParameterGet(
                [
                    'data-inicio' => $dataInicio,
                    'data-fim'    => $dataFim
                ]
            );
            $result   = $client->send();
            $body     = $result->getBody();
            $resposta = json_decode($body);

            if ($result->getStatusCode() == 200) {
                return new JsonMessage($resposta->data);
            }

            throw new \Exception($resposta->error);
        } catch (\Exception $ex) {
            return new JsonException($ex);
        }
    }
}
