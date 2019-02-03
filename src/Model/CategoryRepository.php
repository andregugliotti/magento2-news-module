<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model;

use Gugliotti\News\Api\CategoryRepositoryInterface;
use Gugliotti\News\Api\Data\CategoryInterface;
use Gugliotti\News\Api\Data\CategorySearchResultsInterface;
use Gugliotti\News\Api\Data\CategorySearchResultsInterfaceFactory;
use Gugliotti\News\Model\ResourceModel\Category as CategoryResource;
use Gugliotti\News\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Gugliotti\News\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class CategoryRepository
 *
 * Gugliotti News Category Repository.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CategoryResource
     */
    protected $categoryResource;

    /**
     * @var CategoryCollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @var CategorySearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * CategoryRepository constructor.
     * @param CategoryFactory $categoryFactory
     * @param CategoryResource $categoryResource
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param CategorySearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        CategoryFactory $categoryFactory,
        CategoryResource $categoryResource,
        CategoryCollectionFactory $categoryCollectionFactory,
        CategorySearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->categoryResource = $categoryResource;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * save
     *
     * @param CategoryInterface $category
     * @return CategoryInterface
     * @throws CouldNotSaveException
     */
    public function save(CategoryInterface $category)
    {
        try {
            $this->categoryResource->save($category);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $category;
    }

    /**
     * getById
     *
     * @param int $categoryId
     * @return CategoryInterface
     * @throws NoSuchEntityException
     */
    public function getById($categoryId)
    {
        $category = $this->categoryFactory->create();
        $this->categoryResource->load($category, $categoryId);
        if (!$category->getId()) {
            throw new NoSuchEntityException(__('News Category with id "%1" does not exist.', $categoryId));
        }
        return $category;
    }

    /**
     * delete
     *
     * @param \Gugliotti\News\Api\Data\CategoryInterface $category
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CategoryInterface $category)
    {
        try {
            $this->categoryResource->delete($category);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * deleteById
     *
     * @param string $categoryId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($categoryId)
    {
        return $this->delete($this->getById($categoryId));
    }

    /**
     * getList
     * @param SearchCriteriaInterface $searchCriteria
     * @return CategorySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->categoryCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();
        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * addFiltersToCollection
     * @param SearchCriteriaInterface $searchCriteria
     * @param CategoryCollection $collection
     */
    protected function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, CategoryCollection $collection)
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
     * @param CategoryCollection $collection
     */
    protected function addSortOrdersToCollection(
        SearchCriteriaInterface $searchCriteria,
        CategoryCollection $collection
    ) {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * addPagingToCollection
     * @param SearchCriteriaInterface $searchCriteria
     * @param CategoryCollection $collection
     */
    protected function addPagingToCollection(SearchCriteriaInterface $searchCriteria, CategoryCollection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * buildSearchResult
     * @param SearchCriteriaInterface $searchCriteria
     * @param CategoryCollection $collection
     * @return CategorySearchResultsInterface
     */
    protected function buildSearchResult(SearchCriteriaInterface $searchCriteria, CategoryCollection $collection)
    {
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
