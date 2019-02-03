<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface StorySearchResultsInterface
 *
 * Gugliotti News Story Repository Interface.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.2.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Api
 * @api
 */
interface StorySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get categories list.
     * @return \Gugliotti\News\Api\Data\StoryInterface[]
     */
    function getItems();

    /**
     * Set categories list.
     * @param \Gugliotti\News\Api\Data\StoryInterface[] $items
     * @return $this
     */
    function setItems(array $items);
}
