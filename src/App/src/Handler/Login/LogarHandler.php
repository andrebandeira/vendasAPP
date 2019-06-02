<?php

declare(strict_types=1);

namespace App\Handler\Login;

use Core\Handler\MainHandler;
use Core\Json\JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Http\Client;
use Zend\Http\Request;


class LogarHandler extends MainHandler
{
    private $template;

    public function __construct(
        TemplateRendererInterface $template = null
    ) {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        try {
            $email = $this->getPost($request, 'email');
            $senha = $this->getPost($request, 'senha');

            $client = new Client();
            $client->setMethod(Request::METHOD_POST);
            $client->setUri('http://127.0.0.1/token');
            $client->setParameterPost(
                [
                    'email' => $email,
                    'senha' => $senha
                ]
            );
            $result   = $client->send();
            $body     = $result->getBody();
            $resposta = json_decode($body);

            if ($result->getStatusCode() == 200) {
                return new HtmlResponse(
                    $this->template->render(
                        'app::index',
                        [
                            'token' => $resposta->data
                        ]
                    )
                );
            }

            throw new \Exception($resposta->error);
        } catch (\Exception $ex) {
            return new JsonException($ex);
        }
    }
}
