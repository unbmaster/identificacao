<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Core;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

/**
 * IdentificacaoMiddleware class
 *
 * Middleware autoriza o usuário acessar o serviço
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class IdentificacaoMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $token = JWT::getTokenFromHeader($request);

        if(!$token && isset($_REQUEST['token'])) {
            $token = filter_var($_REQUEST['token'], FILTER_SANITIZE_STRING);
        }

        if ($token && JWT::isValidToken($token) && JWT::isUserRole($token)) {
            $response = $response->withHeader('Authorization',  "Bearer $token");
        }
        else {
            $response = new Response();
            return $response->withStatus(401); # 401 Unauthorized
        }
        return $response;
    }
}