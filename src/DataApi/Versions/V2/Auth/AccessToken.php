<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2\Auth;

/**
 * AccessToken class
 *
 * This class is used to store the access token and refresh token.
 *
 * @package ArielMagbanua\PhpWebflowApi\Auth
 * @author Ariel Magbanua <ariel@arielmagbanua.com>
 */
class AccessToken
{
    /**
     * The AccessToken constructor
     *
     * @param string $accessToken The access token
     * @param string|null $tokenType The token type
     */
    public function __construct(
        protected string $accessToken,
        protected ?string $tokenType,
        protected ?array $scopes = [],
    ) {
        //
    }

    /**
     * Get the access token
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Get the token type
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * Get the scopes
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }
}
