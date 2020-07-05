<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */
namespace Core;

/**
 * Env class
 *
 * Manipula variárveis .env
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class Env
{
    public function __invoke($key = null)
    {
        $env = parse_ini_file('../.env');
        $key = strtoupper($key);
        if (isset($env[$key])) {
            return $env[$key];
        }
        return false;
    }

}