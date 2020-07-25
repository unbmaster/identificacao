<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface;
use Core\{IP, Env};


/**
 * HomeController class
 *
 * Orquestra e trata requisições roteadas
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class HomeController
{
    public function __invoke($request, $response)
    {
        $env = new Env();

        $container = str_replace("\n", "", shell_exec('hostname'));
        $data = [
            'service-name'  => $env('service'),
            'build-number'  => $env('build'),
            'image-name'    => $env('image'),
            'container-id'  => $container,
            'environment'   => $env('envwork'),
            'ip-server' => $_SERVER['SERVER_ADDR'],
            'ip-client' => IP::get()
        ];

        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}