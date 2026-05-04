<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi;

use GuzzleHttp\Client;

/**
 * The API class for the Webflow API
 *
 * @package ArielMagbanua\PhpWebflowApi
 * @author Ariel Magbanua <ariel@arielmagbanua.com>
 */
abstract class BaseApi
{
    /**
     * The base URL for the Webflow API
     *
     * @var string
     */
    protected string $apiBaseUrl = 'https://api.webflow.com';

    /**
     * The HTTP client
     *
     * @var Client|null
     */
    protected ?Client $httpClient = null;

    /**
     * The headers for the API requests
     *
     * @var array
     */
    protected ?array $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    /**
     * The API constructor
     */
    public function __construct()
    {
        // set the HTTP client
        $this->setHttpClient(new Client([
            'base_uri' => $this->apiBaseUrl,
            'headers' => $this->headers,
        ]));
    }

    /**
     * Set the HTTP client
     *
     * @param Client $httpClient The HTTP client
     */
    public function setHttpClient(Client $httpClient): void
    {
        // set the HTTP client
        $this->httpClient = $httpClient;
    }

    /**
     * Create a request
     *
     * @param string $method The HTTP method
     * @param string $uri The URI
     * @param array|null $body The body
     */
    protected function sendRequest(string $method, string $uri, ?array $body = null): ?array
    {
        if (!$this->httpClient) {
            return null; // no configured client
        }

        $requestOptions = [
            'connect_timeout' => 10,
        ];

        if ($body) {
            $requestOptions['body'] = json_encode($body);
        }

        // send the request
        $response = $this->httpClient->request($method, $uri, $requestOptions);

        // get the response body contents
        $contents = $response->getBody()->getContents();

        // decode the response body
        return json_decode($contents, true);
    }
}
