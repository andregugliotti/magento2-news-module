<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Api;

use Gugliotti\News\Api\Data\CategoryInterface;
use Gugliotti\News\Api\Data\CategorySearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface CategoryRepositoryInterface
 *
 * Gugliotti News Category Repository Interface.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Api
 * @api
 */
interface CategoryRepositoryInterface
{
    /**
     * Save category.
     *
     * @param CategoryInterface $category
     * @return CategoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(CategoryInterface $category);

    /**
     * Retrieve category.
     *
     * @param int $categoryId
     * @return CategoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($categoryId);

    /**
     * Retrieve categories matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CategorySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete category.
     *
     * @param CategoryInterface $category
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(CategoryInterface $category);

    /**
     * Delete category by ID.
     *
     * @param int $categoryId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($categoryId);
}
