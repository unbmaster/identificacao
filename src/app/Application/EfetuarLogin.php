<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Application;

use Domain\{Usuario, IdentificacaoService};

/**
 * EfetuarLogin class
 *
 * Realiza Caso de Uso: Efetuar Login
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class EfetuarLogin
{
    public function __invoke($militarId, $senha) {

        # Identificar: o usuário existe?
        $service = new IdentificacaoService();
        $usuario = $service->identificarUsuario($militarId);

        # Autenticar: é quem diz ser?
        $autenticacao = false;
        if ($usuario) {
            $autenticacao = $service->autenticarUsuario($usuario, $senha);
        }

        # Autorizar: o que pode fazer?
        $autorizacao = false;
        if ($autenticacao) {
            $autorizacao = $service->autorizarUsuario($usuario);
        }

        # Gerar token JWT: assinatura para acesso aos serviços
        $token = null;
        if ($autenticacao && $autorizacao) {
            $token = $service->gerarToken($usuario);
        }

        # Dados retornados
        return [
            'usuario' => $usuario,
            'token'   => $token
        ];
    }
}