<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\DataApi\Versions\V2\CollectionItems;

use ArielMagbanua\PhpWebflowApi\DataApi\Cms\CollectionItems\Contracts\StagedItems;

/**
 * The Staged Collection class for the Webflow API
 *
 * @package ArielMagbanua\PhpWebflowApi\Collections\V2
 * @author Ariel Magbanua <ariel@arielmagbanua.com>
 * @todo create unit tests for this class
 */
class StagedCollection extends StagedItems
{
    /**
     * The Staged Collection constructor
     *
     * @param string $accessToken The access token
     * @param string $collectionId The collection ID
     */
    public function __construct(string $accessToken, string $collectionId)
    {
        // call the parent constructor
        parent::__construct(accessToken: $accessToken, version: 'v2', collectionId: $collectionId);
    }

    /**
     * List the items
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
     */
    public function listItems(
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
     * Get an item
     *
     * @param string $id The ID of the item
     * @param string|null $cmsLocaleId The CMS locale ID
     */
    public function getItem(string $id, ?string $cmsLocaleId = null): ?array
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
     * Get an item by slug
     *
     * @param string $slug The slug of the item
     * @param string|null $cmsLocaleId The CMS locale ID
     */
    public function getItemBySlug(string $slug, ?string $cmsLocaleId = null): ?array
    {
        $response = $this->listItems(
            cmsLocaleId: $cmsLocaleId,
            limit: 1,
            slug: $slug,
        );

        if ($response === null) {
            return null;
        }

        $items = $response['items'] ?? null;
        if (!is_array($items) || $items === []) {
            return null;
        }

        return $items[0];
    }

    /**
     * Create the items
     *
     * @param array $items The items to create
     * @param bool|null $skipInvalidFiles Whether to skip invalid files
     */
    public function createItems(array $items, ?bool $skipInvalidFiles = null): ?array
    {
        // create the uri for the request
        $uri = 'collections/' . $this->collectionId . '/items/' . $this->type . '/bulk';

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
     * Update the items
     *
     * @param array $items The items to update
     * @param bool|null $skipInvalidFiles Whether to skip invalid files
     */
    public function updateItems(array $items, ?bool $skipInvalidFiles = null): ?array
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
     * Delete the items
     *
     * Example $items structure:
     * ```php
     * $items = [
     *      [
     *          'id' => '580e64008c9a982ac9b8b754',
     *          'cmsLocaleIds' => ['66f6e966c9e1dc700a857ca3', '66f6e966c9e1dc700a857ca4']
     *      ]
     * ]
     * ```
     * @param array $items The items to delete
     */
    public function deleteItems(array $items): ?array
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

    /**
     * Publish the items
     *
     * Example $ids structure:
     * ```php
     * $ids = ['580e64008c9a982ac9b8b754', '580e64008c9a982ac9b8b755'];
     * ```
     * @param array $ids The IDs of the items to publish
     */
    public function publishItemIds(array $ids): ?array
    {
        // create the uri for the request
        $uri = 'collections/' . $this->collectionId . '/items/publish';

        // send the request
        return $this->sendRequest(
            method: 'POST',
            uri: $uri,
            body: [
                'items' => $ids,
            ],
        );
    }
}
