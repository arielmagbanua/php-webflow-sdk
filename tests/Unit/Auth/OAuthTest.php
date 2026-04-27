<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\Tests\Unit\Auth;

use ArielMagbanua\PhpWebflowApi\Auth\OAuth;
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
}
