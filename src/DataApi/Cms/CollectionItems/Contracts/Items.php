<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\DataApi\Cms\CollectionItems\Contracts;

use ArielMagbanua\PhpWebflowApi\DataApi\Api;

/**
 * The Collection class for the Webflow API
 *
 * @package ArielMagbanua\PhpWebflowApi\DataApi\Cms\CollectionItems\Contracts
 */
abstract class Items extends Api
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
        string $version,
        protected string $collectionId,
    ) {
        // call the parent constructor
        parent::__construct(accessToken: $accessToken, version: $version);
    }

    /**
     * Set the collection ID
     *
     * @param string $collectionId The collection ID
     */
    public function setCollectionId(string $collectionId): self
    {
        $this->collectionId = $collectionId;

        return $this;
    }
}
