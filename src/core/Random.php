<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Core;

/**
 * Random Class
 *
 * Gerador de hash, id, números aleatórios
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class Random
{

    /**
     * UUID
     *
     * Gera identificador único universal (universally unique identifier - UUID/GUID v4)
     * @version 0.1.0
     * @return string UUID/GUID v4
     */
    public static function UUID()
    {
        $data = openssl_random_pseudo_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}