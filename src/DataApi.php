<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi;

use GuzzleHttp\Client;

/**
 * The Base Data API class for the Webflow API
 *
 * @package ArielMagbanua\PhpWebflowApi
 * @author Ariel Magbanua <ariel@arielmagbanua.com>
 */
abstract class DataApi extends Api
{
    /**
     * The resource type. Can be 'live' or ''
     *
     * @var string
     */
    protected string $type = '';

    /**
     * The Data API constructor
     *
     * @param string $accessToken The access token
     * @param string $version The API version
     */
    public function __construct(
        protected string $accessToken,
        protected string $version,
    ) {
        // set the whole base URL with the API version
        $this->apiBaseUrl = $this->apiBaseUrl . '/' . $this->version . '/';

        // set the headers
        $this->headers = array_merge($this->headers, [
            'Authorization' => 'Bearer ' . $this->accessToken,
        ]);

        // configure the HTTP client
        $this->httpClient = new Client([
            'base_uri' => $this->apiBaseUrl,
            'headers' => $this->headers,
        ]);
    }
}
