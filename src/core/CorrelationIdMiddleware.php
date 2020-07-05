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
 * CorrelationIdMiddleware class
 *
 * Middleware para manter Correlation ID entre chamadas
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class CorrelationIdMiddleware
{   
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $correlationId = $request->getHeaderLine('X-Correlation-Id');
        if (empty($correlationId)) {
            $correlationId = Random::UUID();
        }
        $response = $response->withHeader('X-Correlation-Id', $correlationId);
        return $response;
    }
}