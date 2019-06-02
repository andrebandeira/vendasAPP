<?php

declare(strict_types=1);

namespace App\Handler\Venda;

use Core\Handler\MainHandler;
use Core\Json\JsonException;
use Core\Json\JsonMessage;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Http\Client;
use Zend\Http\Request;


class LancarVendaHandler extends MainHandler
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        try {
            $token = $this->getHeader($request, 'token');

            $id = $this->getPost($request, 'id-venda');

            if (!is_numeric($id)) {
                $id = '';
            }else {
                $id = '/'.$id;
            }

            $idVendedor = $this->getPost($request, 'id-vendedor');
            $valorVenda = $this->getPost($request, 'valor-venda');

            $client = new Client();

            if ($id) {
                $client->setMethod(Request::METHOD_PUT);
            } else {
                $client->setMethod(Request::METHOD_POST);
            }

            $client->setUri('http://127.0.0.1/api/venda'.$id);
            $client->setHeaders([
                'token' => $token
            ]);
            $client->setParameterPost(
                [
                    'vendedor' => $idVendedor,
                    'valor'    => $valorVenda
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
