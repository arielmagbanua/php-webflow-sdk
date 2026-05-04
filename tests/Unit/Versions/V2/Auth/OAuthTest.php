<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\Tests\Unit\Versions\V2\Auth;

use ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2\Auth\AccessToken;
use ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2\Auth\OAuth;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class OAuthTest extends TestCase
{
    public function testGetAuthorizationUrlWithAllParams(): void
    {
        $oauth = new OAuth(
            clientId: 'client_id_123',
            clientSecret: 'client_secret_456',
            state: 'random_state',
            redirectUri: 'https://example.com/callback',
            scopes: ['authorized_users:read', 'sites:read'],
        );

        $url = $oauth->getAuthorizationUrl();

        $this->assertStringStartsWith('https://webflow.com/oauth/authorize', $url);

        $queryString = parse_url($url, PHP_URL_QUERY);
        parse_str($queryString, $params);

        $this->assertEquals('client_id_123', $params['client_id']);
        $this->assertEquals('https://example.com/callback', $params['redirect_uri']);
        $this->assertEquals('code', $params['response_type']);
        $this->assertEquals('authorized_users:read sites:read', $params['scope']);
        $this->assertEquals('random_state', $params['state']);
    }

    public function testGetAuthorizationUrlWithoutRedirectUri(): void
    {
        $oauth = new OAuth(
            clientId: 'client_id_123',
            state: 'random_state',
            scopes: ['sites:read'],
        );

        $url = $oauth->getAuthorizationUrl();

        $queryString = parse_url($url, PHP_URL_QUERY);
        parse_str($queryString, $params);

        $this->assertArrayNotHasKey('redirect_uri', $params);
        $this->assertEquals('client_id_123', $params['client_id']);
    }

    public function testGetAuthorizationUrlWithoutScopes(): void
    {
        $oauth = new OAuth(
            clientId: 'client_id_123',
            state: 'random_state',
        );

        $url = $oauth->getAuthorizationUrl();

        $queryString = parse_url($url, PHP_URL_QUERY);
        parse_str($queryString, $params);

        $this->assertEquals('', $params['scope']);
    }

    public function testRequestAccessToken(): void
    {
        $requestPayload = json_decode(file_get_contents(__DIR__ . '/../../../../payloads/requestAccessTokenRequestPayload.json'), true);
        $responsePayload = json_decode(file_get_contents(__DIR__ . '/../../../../payloads/requestAccessTokenResponsePayload.json'), true);

        $container = [];
        $history = Middleware::history($container);
        $mock = new MockHandler([
            new Response(200, [], (string) json_encode($responsePayload)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);
        $client = new Client(['handler' => $handlerStack]);

        $oauth = new OAuth(
            clientId: $requestPayload['client_id'],
            clientSecret: $requestPayload['client_secret']
        );

        // Inject the mock client
        $oauth->setHttpClient($client);

        $accessToken = $oauth->requestAccessToken($requestPayload['code']);

        // Assertions for the returned AccessToken object
        $this->assertInstanceOf(AccessToken::class, $accessToken);
        $this->assertEquals($responsePayload['access_token'], $accessToken->getAccessToken());
        $this->assertEquals('Bearer', $accessToken->getTokenType());
        $this->assertEquals(['cms:read', 'cms:write'], $accessToken->getScopes());

        // Assertions for the request sent
        $this->assertCount(1, $container);
        $request = $container[0]['request'];
        $this->assertEquals('POST', $request->getMethod());
        $this->assertStringContainsString('oauth/access_token', (string) $request->getUri());

        $requestBody = json_decode((string) $request->getBody(), true);
        $this->assertEquals($requestPayload['code'], $requestBody['code']);
        $this->assertEquals($requestPayload['client_id'], $requestBody['client_id']);
        $this->assertEquals($requestPayload['client_secret'], $requestBody['client_secret']);
        $this->assertEquals('authorization_code', $requestBody['grant_type']);
    }
}
