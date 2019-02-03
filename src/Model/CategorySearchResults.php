<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model;

use Gugliotti\News\Api\Data\CategorySearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Class CategorySearchResults
 *
 * Gugliotti News Category Search Results.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model
 */
class CategorySearchResults extends SearchResults implements CategorySearchResultsInterface
{
}
