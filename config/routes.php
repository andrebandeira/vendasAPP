<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/', \App\Handler\Login\LoginHandler::class);
    $app->post('/logar', \App\Handler\Login\LogarHandler::class);

    $app->post('/vendedor', \App\Handler\Vendedor\VendedorHandler::class);
    $app->post('/cadastrarVendedor', \App\Handler\Vendedor\CadastrarVendedorHandler::class);
    $app->post('/buscarTodosVendedores', \App\Handler\Vendedor\BuscarTodosVendedoresHandler::class);

    $app->post('/venda', \App\Handler\Venda\VendaHandler::class);
    $app->post('/lancarVenda', \App\Handler\Venda\LancarVendaHandler::class);
    $app->post('/buscarTodasVendas', \App\Handler\Venda\BuscarTodasVendasHandler::class);

};
