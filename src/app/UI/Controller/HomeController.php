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
    public static function info($request, $response)
    {
        $env = new Env();
        $container_env = '';
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $port = parse_url($url, PHP_URL_PORT);
        $port_env = substr($port,0,3);
        switch ($port_env) {
            case 443 : $container_env = 'Produção'; break;
            case 444 : $container_env = 'Desenvolvimento'; break;
        }
        $data = [
            'service' => [
                'name' => $env('service'),
                'build' => $env('build'),
                'container' => $env('container'),
                'port' => $port,
                'env' => $container_env,
            ],
            'ip-server' => $_SERVER['SERVER_ADDR'],
            'ip-client' => IP::get()
        ];
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}