<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

/**
 * Ponto central das requisições e rotas de acesso aos serviços
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->add(new Core\CorrelationIdMiddleware);

$app->any('/v1/identificacao/login', 'Controller\IdentificacaoController:login');

$app->any('/v1/identificacao', 'Controller\HomeController');

$app->run();