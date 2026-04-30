<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\Collections;

use ArielMagbanua\PhpWebflowApi\DataApi;

/**
 * The Collection class for the Webflow API
 *
 * @package ArielMagbanua\PhpWebflowApi\Collections
 * @author Ariel Magbanua <ariel@arielmagbanua.com>
 */
abstract class Collection extends DataApi
{
    /**
     * The resource type. Can be 'live' or ''
     *
     * @var string
     */
    protected string $type = '';

    /**
     * The Collection constructor
     *
     * @param string $accessToken The access token
     * @param string $version The API version
     * @param string $collectionId The collection ID
     */
    public function __construct(
        string $accessToken,
        protected string $version,
        protected string $collectionId,
    ) {
        // call the parent constructor
        parent::__construct(accessToken: $accessToken, version: $version);
    }
}
