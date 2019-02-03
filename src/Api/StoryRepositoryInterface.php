<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Api;

use Gugliotti\News\Api\Data\StoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface StoryRepositoryInterface
 *
 * Gugliotti News Story Repository Interface.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.2.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Api
 * @api
 */
interface StoryRepositoryInterface
{
    /**
     * Save story.
     *
     * @param \Gugliotti\News\Api\Data\StoryInterface $story
     * @return \Gugliotti\News\Api\Data\StoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    function save(StoryInterface $story);

    /**
     * Retrieve story.
     *
     * @param int $storyId
     * @return \Gugliotti\News\Api\Data\StoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    function getById($storyId);

    /**
     * Retrieve categories matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Gugliotti\News\Api\Data\StorySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete story.
     *
     * @param \Gugliotti\News\Api\Data\StoryInterface $story
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    function delete(StoryInterface $story);

    /**
     * Delete story by ID.
     *
     * @param int $storyId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    function deleteById($storyId);
}
