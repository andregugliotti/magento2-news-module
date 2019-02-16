<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model;

use Gugliotti\News\Api\StoryRepositoryInterface;
use Gugliotti\News\Api\Data\StoryInterface;
use Gugliotti\News\Api\Data\StorySearchResultsInterface;
use Gugliotti\News\Api\Data\StorySearchResultsInterfaceFactory;
use Gugliotti\News\Model\ResourceModel\Story as StoryResource;
use Gugliotti\News\Model\ResourceModel\Story\CollectionFactory as StoryCollectionFactory;
use Gugliotti\News\Model\ResourceModel\Story\Collection as StoryCollection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class StoryRepository
 *
 * Gugliotti News Story Repository.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.2.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class StoryRepository implements StoryRepositoryInterface
{
    /**
     * @var StoryFactory
     */
    protected $storyFactory;

    /**
     * @var StoryResource
     */
    protected $storyResource;

    /**
     * @var StoryCollectionFactory
     */
    protected $storyCollectionFactory;

    /**
     * @var StorySearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * StoryRepository constructor.
     * @param StoryFactory $storyFactory
     * @param StoryResource $storyResource
     * @param StoryCollectionFactory $storyCollectionFactory
     * @param StorySearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        StoryFactory $storyFactory,
        StoryResource $storyResource,
        StoryCollectionFactory $storyCollectionFactory,
        StorySearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->storyFactory = $storyFactory;
        $this->storyResource = $storyResource;
        $this->storyCollectionFactory = $storyCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * save
     *
     * @param StoryInterface $story
     * @return StoryInterface
     * @throws CouldNotSaveException
     */
    public function save(StoryInterface $story)
    {
        try {
            $this->storyResource->save($story);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $story;
    }

    /**
     * getById
     *
     * @param int $storyId
     * @return StoryInterface
     * @throws NoSuchEntityException
     */
    public function getById($storyId)
    {
        $story = $this->storyFactory->create();
        $this->storyResource->load($story, $storyId);
        if (!$story->getId()) {
            throw new NoSuchEntityException(__('News Story with id "%1" does not exist.', $storyId));
        }
        return $story;
    }

    /**
     * delete
     *
     * @param \Gugliotti\News\Api\Data\StoryInterface $story
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(StoryInterface $story)
    {
        try {
            $this->storyResource->delete($story);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * deleteById
     *
     * @param string $storyId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($storyId)
    {
        return $this->delete($this->getById($storyId));
    }

    /**
     * getList
     * @param SearchCriteriaInterface $searchCriteria
     * @return StorySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->storyCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();
        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * addFiltersToCollection
     * @param SearchCriteriaInterface $searchCriteria
     * @param StoryCollection $collection
     */
    protected function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, StoryCollection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * addSortOrdersToCollection
     * @param SearchCriteriaInterface $searchCriteria
     * @param StoryCollection $collection
     */
    protected function addSortOrdersToCollection(
        SearchCriteriaInterface $searchCriteria,
        StoryCollection $collection
    ) {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * addPagingToCollection
     * @param SearchCriteriaInterface $searchCriteria
     * @param StoryCollection $collection
     */
    protected function addPagingToCollection(SearchCriteriaInterface $searchCriteria, StoryCollection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * buildSearchResult
     * @param SearchCriteriaInterface $searchCriteria
     * @param StoryCollection $collection
     * @return StorySearchResultsInterface
     */
    protected function buildSearchResult(SearchCriteriaInterface $searchCriteria, StoryCollection $collection)
    {
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
