<?php

use Firebase\JWT\JWT;

function getJWTFromRequest($authHeader): string
{
    if (is_null($authHeader)) {
        throw new Exception('Missing or invalid JWT in request');
    }

    return explode(' ', $authHeader)[1];
}

function validateJWTFromRequest(string $encodedToken)
{
    $decodedToken = JWT::decode($encodedToken, JWT_KEY, ['HS256']);
}

function getSignedJWTForUser(string $username)
{
    $iat = time();
    $nbf = $iat + 10;
    $exp = $iat + 3600;

    $payload = [
        'iss'   => 'The_claim',
        'aud'   => 'The_Aud',
        'iat'   => $iat,
        'nbf'   => $nbf,
        'exp'   => $exp,
        'data'  => $userdata,
    ];

    $jwt_token = JWT::encode($payload, JWT_KEY);
    return $jwt_token;
}