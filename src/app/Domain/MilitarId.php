<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Domain;

/**
 * MilitarId class (Object Value)
 *
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class MilitarId
{
    private $militarId;

    function __construct($militarId)
    {
        if (!preg_match('/^\d{10}$/', $militarId)) {
            throw new \InvalidArgumentException(
                "Id '{$militarId}' deve ser numérico e ter 10 dígitos"
            );
        }
        $this->militarId= $militarId;
    }

    public function __toString()
    {
        return $this->militarId;
    }
}