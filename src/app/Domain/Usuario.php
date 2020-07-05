<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Domain;

use Nette\Utils\DateTime;

/**
 * Usuario class (Entity)
 *
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class Usuario
{
    private $militarId;
    private $posto;
    private $nome;
    private $senha;
    private $email;
    private $criadoEm;
    private $permissoes;

    function __construct(
        MilitarId $militarId,
        string $nome,
        string $posto,
        Senha $senha,
        Email $email,
        String $criadoEm,
        Array $permissoes)
    {
        $this->militarId = $militarId;
        $this->posto = $posto;
        $this->nome = $nome;
        $this->senha = $senha;
        $this->email = $email;
        $this->criadoEm = date('Y-m-d H:i:s');
        $this->permissoes = $permissoes;
    }

    /**
     * @return MilitarId
     */
    public function getMilitarId(): MilitarId
    {
        return $this->militarId;
    }

    /**
     * @param MilitarId $militarId
     */
    public function setMilitarId(MilitarId $militarId): void
    {
        $this->militarId = $militarId;
    }

    /**
     * @return string
     */
    public function getPosto(): string
    {
        return $this->posto;
    }

    /**
     * @param string $posto
     */
    public function setPosto(string $posto): void
    {
        $this->posto = $posto;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return Senha
     */
    public function getSenha(): Senha
    {
        return $this->senha;
    }

    /**
     * @param Senha $senha
     */
    public function setSenha(Senha $senha): void
    {
        $this->senha = $senha;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @param Email $email
     */
    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    /**
     * @return false|string
     */
    public function getCriadoEm()
    {
        return $this->criadoEm;
    }

    /**
     * @param false|string $criadoEm
     */
    public function setCriadoEm($criadoEm): void
    {
        $this->criadoEm = $criadoEm;
    }

    /**
     * @return array
     */
    public function getPermissoes(): array
    {
        return $this->permissoes;
    }

    /**
     * @param array $permissoes
     */
    public function setPermissoes(array $permissoes): void
    {
        $this->permissoes = $permissoes;
    }

}