<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Domain;

/**
 * Senha class (Object Value)
 *
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class Senha
{
    private $senha;

    function __construct($senha)
    {
        if (!preg_match('/^\d{8}$/', $senha)) {
            throw new \InvalidArgumentException(
                "Senha '{$senha}' deve ser numérica e ter 8 dígitos"
            );
        }
        $this->senha = $senha;
    }

    public function __toString()
    {
        return (string)$this->senha;
    }
}