<?php

use App\Models\ApiAuthFilterLogModel;
use Firebase\JWT\JWT;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;
use Config\Services;

function getJWTFromRequest($authHeader): string
{
    if (is_null($authHeader)) {
        throw new Exception('Missing or invalid JWT in request');
    }

    return explode(' ', $authHeader)[1];
}

function validateAccessToken(string $encodedToken, bool $turnOnLog = false) : object
{
    // start logs
    if ($turnOnLog) {
        $apiAuthFilterLogModel = new ApiAuthFilterLogModel();
        $timeNow = Time::now();
        $apiAuthFilterLogModel->insert([
            'username'          => 'test',
            'access_token'      => $encodedToken,
            'access_token_key'  => Services::getAccessTokenKey(),
            'created_at'        => $timeNow->toDateTimeString(),
            'updated_at'        => $timeNow->toDateTimeString(),
            'deleted_at'        => null,
        ]);
    }
    // end logs

    $decodedToken   = JWT::decode($encodedToken, Services::getAccessTokenKey(), ['HS256']);
    $userModel      = new UserModel();
    return $userModel->findByUsername($decodedToken->data->username);
}

function validateRefreshToken(string $encodedToken): string
{
    $decodedToken = JWT::decode($encodedToken, Services::getRefreshTokenKey(), ['HS256']);

    return $decodedToken->data->username;
}

function createAccessToken(array $data): string
{
    $iat = time();
    $nbf = $iat + 10;
    $exp = $iat + (int) Services::getAccessTokenLifetime();
    
    $payload = [
        'iss'   => 'The_Claim1',
        'aud'   => 'The_Aud1',
        'iat'   => $iat,
        'nbf'   => $nbf,
        'exp'   => $exp,
        'data'  => $data,
    ];

    $jwt_token = JWT::encode($payload, Services::getAccessTokenKey());
    return $jwt_token;
}

function createRefreshToken(array $data): string
{
    $iat = time();
    $payload = [
        'iss'   => 'The_Claim2',
        'aud'   => 'The_Aud2',
        'iat'   => $iat,
        'data'  => $data,
    ];

    $jwt_token = JWT::encode($payload, Services::getRefreshTokenKey());
    return $jwt_token;
}