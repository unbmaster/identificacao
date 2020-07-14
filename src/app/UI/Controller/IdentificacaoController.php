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

/**
 * planosController class
 *
 * Orquestra e trata requisições roteadas
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class IdentificacaoController
{
    public static function login($request, $response)
    {

        $input = $request->getParsedBody();
        if (!$input) {
            $input = $request->getQueryParams();
        }

        if(!$input) {
            return $response->withStatus(401);
        }
        else {
            $input     = filter_var_array($input, FILTER_SANITIZE_STRING);
            $militarId = $input['militarId'];
            $senha     = $input['senha'];
            $dados     = (new \Application\EfetuarLogin)($militarId, $senha);
            $usuario   = $dados['usuario'];
            $token     = $dados['token'];

            if (!$usuario) {
                return $response->withStatus(500);
            }

            # Dados retornados em JSON
            $output = [
                'usuario' => [
                    'militarId' => (string)$usuario->getMilitarId(),
                    'posto'     => $usuario->getPosto(),
                    'nome'      => $usuario->getNome(),
                    'email'     => (string)$usuario->getEmail()
                ],
                'token'         => $token
            ];

            if (!$token) {
                return $response->withStatus(401);
            }
            $response = $response->withHeader('Authorization', "Bearer {$token}");
        }
        $output = json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        $response->getBody()->write($output);
        return $response->withStatus(201);
    }
}