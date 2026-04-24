<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\Collections;

use ArielMagbanua\PhpWebflowApi\Collections\Contracts\LiveItems;

/**
 * The Live Collection class for the Webflow API
 *
 * @package ArielMagbanua\PhpWebflowApi\Collections\V2
 * @author Ariel Magbanua <ariel@arielmagbanua.com>
 * @todo create unit tests for this class
 */
class LiveCollection extends LiveItems
{
    /**
     * The Live Collection constructor
     *
     * @param string $accessToken The access token
     * @param string $collectionId The collection ID
     */
    public function __construct(
        string $accessToken,
        protected string $collectionId,
    ) {
        parent::__construct(accessToken: $accessToken, version: 'v2');
    }

    /**
     * List the live items
     *
     * @param string|null $cmsLocaleId The CMS locale ID
     * @param int|null $offset The offset
     * @param int|null $limit The limit
     * @param string|null $name The name
     * @param string|null $slug The slug
     * @param array|null $createdOn The created on
     * @param array|null $lastPublished The last published
     * @param array|null $lastUpdated The last updated
     * @param string|null $sortBy The sort by
     * @param string|null $sortOrder The sort order
     * @return array|null
     */
    public function listLiveItems(
        ?string $cmsLocaleId = null,
        ?int $offset = null,
        ?int $limit = null,
        ?string $name = null,
        ?string $slug = null,
        ?array $createdOn = null,
        ?array $lastPublished = null,
        ?array $lastUpdated = null,
        ?string $sortBy = null,
        ?string $sortOrder = null,
    ): ?array {
        // create the uri for the request
        $uri = 'collections/' . $this->collectionId . '/items/' . $this->type;

        // append the arguments as query parameters
        // but only set the parameters that are not null
        $uri .= '?' . http_build_query(array_filter([
            'cmsLocaleId' => $cmsLocaleId,
            'offset' => $offset,
            'limit' => $limit,
            'name' => $name,
            'slug' => $slug,
            // TODO: Add the createdOn, lastPublished, and lastUpdated parameters
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
        ]));

        // send the request
        return $this->sendRequest(
            method: 'GET',
            uri: $uri,
        );
    }

    /**
     * Get a live item
     *
     * @param string $id The ID of the live item
     * @param string|null $cmsLocaleId The CMS locale ID
     * @return array|null
     */
    public function getLiveItem(string $id, ?string $cmsLocaleId = null): ?array
    {
        // create the uri for the request
        $uri = 'collections/' . $this->collectionId . "/items/$id/" . $this->type;

        // append the arguments as query parameters
        // but only set the parameters that are not null
        $uri .= '?' . http_build_query(array_filter([
            'cmsLocaleId' => $cmsLocaleId,
        ]));

        // send the request
        return $this->sendRequest(
            method: 'GET',
            uri: $uri
        );
    }

    /**
     * Create the live items
     *
     * @param array $items The items to create
     * @param bool|null $skipInvalidFiles Whether to skip invalid files
     * @return array|null
     */
    public function createLiveItems(array $items, ?bool $skipInvalidFiles = null): ?array
    {
        // create the uri for the request
        $uri = 'collections/' . $this->collectionId . '/items/' . $this->type;

        // append the arguments as query parameters
        // but only set the parameters that are not null
        $uri .= '?' . http_build_query(array_filter([
            'skipInvalidFiles' => $skipInvalidFiles,
        ]));

        // send the request
        return $this->sendRequest(
            method: 'POST',
            uri: $uri,
            body: [
                'items' => $items,
            ],
        );
    }

    /**
     * Update the live items
     *
     * @param array $items The items to update
     * @param bool|null $skipInvalidFiles Whether to skip invalid files
     * @return array|null
     */
    public function updateLiveItems(array $items, ?bool $skipInvalidFiles = null): ?array
    {
        // create the uri for the request
        $uri = 'collections/' . $this->collectionId . '/items/' . $this->type;

        // append the arguments as query parameters
        // but only set the parameters that are not null
        $uri .= '?' . http_build_query(array_filter([
            'skipInvalidFiles' => $skipInvalidFiles,
        ]));

        // send the request
        return $this->sendRequest(
            method: 'PATCH',
            uri: $uri,
            body: [
                'items' => $items,
            ],
        );
    }

    /**
     * Unpublish the live items
     *
     * Example $items structure:
     * ```php
     * $items = [
     *      [
     *          'id' => '580e64008c9a982ac9b8b754',
     *          'cmsLocaleIds' => ['en', 'nl']
     *      ]
     * ]
     * ```
     * @param array $items The items to unpublish
     * @return array|null
     */
    public function unpublishLiveItems(array $items): ?array
    {
        // create the uri for the request
        $uri = 'collections/' . $this->collectionId . '/items/' . $this->type;

        // send the request
        return $this->sendRequest(
            method: 'DELETE',
            uri: $uri,
            body: [
                'items' => $items,
            ],
        );
    }
}
