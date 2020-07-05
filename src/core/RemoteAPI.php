<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Core;

/**
 * RemoteAPI class
 *
 * Faz chamadas à API de serviços externos
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class RemoteAPI
{
    public static function callByGet($url, $token = '', $correlationId= '')
    {
        $content = http_build_query([]);
        $stream_opts = [
            "ssl" => [
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ],
            "http" => [
                "method"  => "GET",
                'timeout' => 30,
                'ignore_errors'=> true,
                "content" => $content,
                "header"  => "Authorization: Bearer {$token}\r\n" .
                             "X-Correlation-Id: {$correlationId}\r\n" .
                             "Content-Type: application/x-www-form-urlencoded\r\n" .
                             "Content-Length: " . strlen($content) . "\r\n"
            ]
        ];
        return @file_get_contents($url, false, stream_context_create($stream_opts));
     }
}