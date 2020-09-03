<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Infrastructure;

use Domain\{UsuarioRepositoryInterface, MilitarId, Usuario};
use Core\Redis;

/**
 * UsuarioRepository Class
 *
 * Manipula dados do usuario - Redis
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class UsuarioRepository implements UsuarioRepositoryInterface
{
    /**
     * @param MilitarId $militarId
     * @return string
     */
    public function get(MilitarId $militarId) {
        $redis  = new Redis();
        return $redis->get($militarId);
    }

    /**
     * @param MilitarId $militarId
     * @param Usuario $usuario
     * @return string
     */
    public function set(MilitarId $militarId, Usuario $usuario) {
        $redis = new Redis();
        return $redis->set($militarId, $usuario);
    }

    /**
     * @param MilitarId $militarId
     * @return int
     */
    public function del(MilitarId $militarId) {
        $redis  = new Redis();
        return $redis->del($militarId);
    }
}