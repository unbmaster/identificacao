<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Domain;

/**
 * UsuarioRepositoryInterface interface
 *
 * Manipula dados do usuario presentes no Redis
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
interface UsuarioRepositoryInterface
{
    public function get(MilitarId $militarId);
    public function set(MilitarId $militarId, Usuario $usuario);
    public function del(MilitarId $militarId);
}