<?php

declare(strict_types=1);

namespace ArielMagbanua\PhpWebflowApi\Collections\Contracts;

use ArielMagbanua\PhpWebflowApi\DataApi;

/**
 * The Live Items contract for the Webflow API
 *
 * @package ArielMagbanua\PhpWebflowApi\Collections\Contracts
 * @author Ariel Magbanua <ariel@arielmagbanua.com>
 */
abstract class LiveItems extends DataApi
{
    /**
     * The resource type. Can be 'live' or ''
     *
     * @var string
     */
    protected string $type = 'live';

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
    abstract public function listItems(
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
    ): ?array;

    /**
     * Get a live item
     *
     * @param string $id The ID of the live item
     * @param string|null $cmsLocaleId The CMS locale ID
     * @return array|null
     */
    abstract public function getItem(string $id, ?string $cmsLocaleId = null): ?array;

    /**
     * Create the live items
     *
     * @param array $items The items to create
     * @param bool|null $skipInvalidFiles Whether to skip invalid files
     * @return array|null
     */
    abstract public function createItems(array $items, ?bool $skipInvalidFiles = null): ?array;

    /**
     * Update the live items
     *
     * @param array $items The items to update
     * @param bool|null $skipInvalidFiles Whether to skip invalid files
     * @return array|null
     */
    abstract public function updateItems(array $items, ?bool $skipInvalidFiles = null): ?array;

    /**
     * Unpublish the live items
     *
     * @param array $ids The IDs of the live items to unpublish
     * @return array|null
     */
    abstract public function unpublishItems(array $ids): ?array;
}
