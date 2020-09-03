<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Domain;

use Infrastructure\UsuarioRepository;

/**
 * IdentificacaoService class
 *
 * Identificação do usuário
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class IdentificacaoService
{

    /**
     * identificarUsuario Method
     *
     * Identifica um usuário pelo id caso exista
     * @param string $militarId informado no login (username)
     * @return bool|Usuario false se usuário não encontrado ou Usuario
     */
    public function identificarUsuario($militarId)
    {
        try {
            $repositorio = new UsuarioRepository();
            $dados = $repositorio->get(new MilitarId($militarId));

            if (!$dados) {
                return false;
            }
            return new Usuario(
                new MilitarId($militarId),
                $dados['name'],
                $dados['rank'],
                new Senha($dados['password']),
                new Email($dados['email']),
                $dados['createdAt'],
                $dados['roles']
            );
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * autenticarUsuario Method
     *
     * Verifica se usuário é quem diz ser (compara senhas)
     * @param Usuario $usuario identificado
     * @param string $senha informada no login
     * @return bool true se senha confere e false caso contrário
     */
    public function autenticarUsuario(Usuario $usuario, $senha)
    {
        try {
            $senhaTest = (string)new Senha($senha);
            $senhaReal = (string)$usuario->getSenha();
            if ($senhaTest === $senhaReal) {
                return true;
            } else {
                echo 'Senha não confere';
                return false;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * autorizarUsuario Method
     *
     * Verifica as permissões que o usuário possui
     * @param Usuario $usuario identificado e autorizado
     * @return array|bool permissões do usuário ou false se não existir
     */
    public function autorizarUsuario(Usuario $usuario)
    {
        $permissoes = (array)$usuario->getPermissoes();
        if ($permissoes) {
            return $permissoes;
        } else {
            echo 'Não possui permissão';
            return false;
        }
    }

    /**
     * gerarToken Method
     *
     * Gera um token para acesso aos serviços
     * @param Usuario $usuario identificado, autenticado e autorizado
     * @return string token JWT
     */
    public function gerarToken(Usuario $usuario)
    {
        $payload = [
            'sub'   => (string)$usuario->getMilitarId(),
            'iss'   => 'login',
            'exp'   => time() * 3600,
            'name'  => (string)$usuario->getNome(),
            'rank'  => (string)$usuario->getPosto(),
            'email' => (string)$usuario->getEmail(),
            'roles' => (array)$usuario->getPermissoes()
        ];
        return \Core\JWT::getToken($payload);
    }
}