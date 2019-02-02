<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface CategorySearchResultsInterface
 *
 * Gugliotti News Category Repository Interface.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Api
 * @api
 */
interface CategorySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get categories list.
     * @return \Gugliotti\News\Api\Data\CategoryInterface[]
     */
    public function getItems();

    /**
     * Set categories list.
     * @param \Gugliotti\News\Api\Data\CategoryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
