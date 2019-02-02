<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model;

use Gugliotti\News\Api\Data\CategorySearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class CategorySearchResults extends SearchResults implements CategorySearchResultsInterface
{
}
