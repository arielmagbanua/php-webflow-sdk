<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2\Auth;

use ArielMagbanua\PhpWebflowApi\BaseApi;

/**
 * OAuth class
 *
 * This class is used to authenticate with the Webflow API using OAuth 2.0.
 *
 * @package ArielMagbanua\PhpWebflowApi\Auth
 * @author Ariel Magbanua <ariel@arielmagbanua.com>
 */
class OAuth extends BaseApi
{
    /**
     * The OAuth constructor
     *
     * @param string|null $clientId The client ID
     * @param string|null $clientSecret The client secret
     * @param string|null $state The state
     * @param string|null $redirectUri The redirect URI
     * @param array|null $scopes The scopes
     */
    public function __construct(
        protected ?string $clientId = null,
        protected ?string $clientSecret = null,
        protected ?string $state = null,
        protected ?string $redirectUri = null,
        protected ?array $scopes = null,
    ) {
        // call the parent constructor
        parent::__construct();
    }

    /**
     * Get the authorization URL
     */
    public function getAuthorizationUrl(): string
    {
        // get the base authorize url
        $url = 'https://webflow.com/oauth/authorize';

        // authorization params
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => implode(' ', $this->scopes ?? []),
            'state' => $this->state,
        ];

        // remove the redirect uri if it is not set
        if (!$this->redirectUri) {
            unset($params['redirect_uri']);
        }

        // build the authorization url
        return $url . '?' . http_build_query($params);
    }

    /**
     * Get the access token
     *
     * @param string $code The authorization code
     */
    public function requestAccessToken(string $code): AccessToken
    {
        // send the request
        $data = $this->sendRequest(
            method: 'POST',
            uri: 'oauth/access_token',
            body: [
                'code' => $code,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'authorization_code',
            ],
        );

        // return the access token
        return new AccessToken(
            accessToken: $data['access_token'],
            scopes: isset($data['scope']) ? explode(' ', $data['scope']) : ($data['scopes'] ?? []),
            tokenType: ucfirst($data['token_type'] ?? 'Bearer'),
        );
    }
}
