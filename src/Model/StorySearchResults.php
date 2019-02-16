<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model;

use Gugliotti\News\Api\Data\StorySearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Class StorySearchResults
 *
 * Gugliotti News Story Search Results.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.2.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model
 */
class StorySearchResults extends SearchResults implements StorySearchResultsInterface
{
}
