<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Core;

use PHPUnit\Exception;

/**
 * JWT class
 *
 * Manipula Token JWT
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class JWT
{
    public static function getToken($payload)
    {

        # Config
        $cfg = new Config();
        $secret = $cfg('app.secret');

        # JWT header
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];
        $header = json_encode($header);
        $header = self::base64UrlEncode($header);

        # JWT payload
        $payload = json_encode($payload);
        $payload = self::base64UrlEncode($payload);

        # JWT signature
        $signature = hash_hmac('sha256', "$header.$payload", $secret, true);
        $signature = self::base64UrlEncode($signature);

        $token = "$header.$payload.$signature";

        return $token;
    }

    public static function isValidToken($token) {

        # Split token
        list($header, $payload, $signature) = explode('.', $token);

        # Config
        $cfg = new Config();
        $secret = $cfg('app.secret');

        # New token valid
        $signature = hash_hmac('sha256', "$header.$payload", $secret, true);
        $signature = self::base64UrlEncode($signature);
        $tokenValido = "$header.$payload.$signature";

        return $token === $tokenValido;
    }

    public static function base64UrlEncode ($text) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }

    public static function getTokenFromHeader($request)
    {
        try {
            $token = $request->getHeaderLine('Authorization');
            $token = str_replace('Bearer ', '', $token);
            return $token;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public static function getCorrelationIdFromHeader($request)
    {
        try {
            $correlationId = $request->getHeaderLine('X-Correlation-Id');
            return $correlationId;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return array
     */
    public static function getRoles($token)
    {
        list($header, $payload, $signature) = explode('.', $token);
        $payload = base64_decode($payload);
        $payload = json_decode($payload, true);
        return $payload['roles'];
    }

    /**
     * @return array
     */
    public static function getPayloadFromToken($token)
    {
        list($header, $payload, $signature) = explode('.', $token);
        $payload = base64_decode($payload);
        $payload = json_decode($payload, true);
        return $payload;
    }

    /**
     * @return array
     */
    public static function getPayloadFromRequest($request)
    {
        $token = self::getTokenFromHeader($request);
        list($header, $payload, $signature) = explode('.', $token);
        $payload = base64_decode($payload);
        $payload = json_decode($payload, true);
        return $payload;
    }

    /**
     * @return bool
     */
    public static function isUserRole($token)
    {
        list($header, $payload, $signature) = explode('.', $token);
        $payload = base64_decode($payload);
        $payload = json_decode($payload, true);
        return in_array('ROLE_USER', $payload['roles']);
    }

    /**
     * @return bool
     */
    public static function isAdminRole($token)
    {
        list($header, $payload, $signature) = explode('.', $token);
        $payload = base64_decode($payload);
        $payload = json_decode($payload, true);
        return in_array('ROLE_ADMIN', $payload['roles']);
    }
}