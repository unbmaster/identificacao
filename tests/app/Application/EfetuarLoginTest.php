<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Application\Tests;

use Application\EfetuarLogin;
use PHPUnit\Framework\TestCase;

/**
 * EfetuarLoginTest class
 *
 * Testa Caso de Uso: Efetuar Login
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class EfetuarLoginTest extends TestCase
{

    public function testUsuarioEfetuaLogin() {
        $login = new EfetuarLogin();
        $data  = $login('1234567890', '12345678');
        self::assertArrayHasKey('token', $data);
        self::assertNotEmpty($data['token']);
    }

}