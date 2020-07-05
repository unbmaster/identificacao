<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Domain;

/**
 * Email class (Object Value)
 *
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class Email
{
    private $email;

    function __construct($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(
                "O e-mail '{$email}' não é válido"
            );
        }
        $this->email = $email;
    }

    public function __toString()
    {
        return $this->email;
    }
}