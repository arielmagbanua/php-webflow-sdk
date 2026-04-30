<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\Versions\v2\Authorization;

use ArielMagbanua\PhpWebflowApi\DataApi;

/**
 * The Token class for the Webflow API
 *
 * @package ArielMagbanua\PhpWebflowApi\Auth\Authorization\v2
 * @author Ariel Magbanua <ariel@arielmagbanua.com>
 * @todo create unit tests for this class
 */
class Token extends DataApi
{
    /**
     * The Token constructor
     *
     * @param string $accessToken The access token
     */
    public function __construct(protected string $accessToken)
    {
        parent::__construct(accessToken: $accessToken, version: 'v2');
    }

    /**
     * Information about the Authorized User
     */
    public function getUserInfo(): ?array
    {
        return $this->sendRequest(
            method: 'GET',
            uri: 'token/authorized_by',
        );
    }

    /**
     * Information about the authorization token
     */
    public function getInfo(): ?array
    {
        return $this->sendRequest(
            method: 'GET',
            uri: 'token/introspect',
        );
    }
}
