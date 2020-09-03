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

        return "$header.$payload.$signature";

    }

    public static function isValidToken($token) {

        # Split token
        $token_array = explode('.', $token);
        $header = $token_array[0];
        $payload = $token_array[1];

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
            if (!$token) {
                $input = $request->getQueryParams();
                $input     = filter_var_array($input, FILTER_SANITIZE_STRING);
                return $token = $input['token'];
            }
            return str_replace('Bearer ', '', $token);
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public static function getCorrelationIdFromHeader($request)
    {
        try {
            return $request->getHeaderLine('X-Correlation-Id');
        }
        catch (\Exception $e) {
            return false;
        }
    }


    /**
     * @return array
     */
    public static function getPayloadFromToken($token)
    {
        $token_array = explode('.', $token);
        $payload = $token_array[1];
        $payload = base64_decode($payload);
        return json_decode($payload, true);
    }

    /**
     * @return array
     */
    public static function getPayloadFromRequest($request)
    {
        $token = self::getTokenFromHeader($request);
        $token_array = explode('.', $token);
        $payload = $token_array[1];
        $payload = base64_decode($payload);
        return json_decode($payload, true);
    }

    /**
     * @return bool
     */
    public static function isUserRole($token)
    {
        $token_array = explode('.', $token);
        $payload = $token_array[1];
        $payload = base64_decode($payload);
        $payload = json_decode($payload, true);
        return in_array('ROLE_USER', $payload['roles']);
    }

    /**
     * @return bool
     */
    public static function isAdminRole($token)
    {
        $token_array = explode('.', $token);
        $payload = $token_array[1];
        $payload = base64_decode($payload);
        $payload = json_decode($payload, true);
        return in_array('ROLE_ADMIN', $payload['roles']);
    }
}