<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\Tests\Unit\Versions\V2;

use ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2\TokenInfo;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class TokenInfoTest extends TestCase
{
    /**
     * Test getUserInfo method
     */
    public function testGetUserInfo(): void
    {
        // Load the payload
        $payloadPath = __DIR__ . '/../../../payloads/V2/Authorization/getUserInfoResponsePayload.json';
        $payload = json_decode(file_get_contents($payloadPath), true);

        // Mock the Guzzle client
        $mock = new MockHandler([
            new Response(200, [], json_encode($payload)),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        // Instantiate Token and set the mocked client
        $token = new TokenInfo('test-access-token');
        $token->setHttpClient($client);

        // Call the method and assert the result
        $result = $token->getAuthorizationUserInfo();
        $this->assertSame($payload, $result);
    }

    /**
     * Test getInfo method
     */
    public function testGetInfo(): void
    {
        // Load the payload
        $payloadPath = __DIR__ . '/../../../payloads/V2/Authorization/getInfoResponsePayload.json';
        $payload = json_decode(file_get_contents($payloadPath), true);

        // Mock the Guzzle client
        $mock = new MockHandler([
            new Response(200, [], json_encode($payload)),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        // Instantiate Token and set the mocked client
        $token = new TokenInfo('test-access-token');
        $token->setHttpClient($client);

        // Call the method and assert the result
        $result = $token->getAuthorizationInfo();
        $this->assertSame($payload, $result);
    }
}
