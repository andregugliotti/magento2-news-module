<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Block\Category;

use Gugliotti\News\Api\CategoryRepositoryInterface;
use Gugliotti\News\Model\ResourceModel\Category as CategoryResource;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

/**
 * Class Listing
 *
 * Gugliotti News Category List Block.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Block\Category
 */
class Listing extends Template
{
    /**
     * @var CategoryResource
     */
    protected $categoryResource;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * Listing constructor.
     * @param Template\Context $context
     * @param CategoryResource $categoryResource
     * @param CategoryRepositoryInterface $categoryRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CategoryResource $categoryResource,
        CategoryRepositoryInterface $categoryRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        $this->categoryResource = $categoryResource;
        $this->categoryRepository = $categoryRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    /**
     * getCategories
     * @param bool $onlyEnabled
     * @return \Gugliotti\News\Api\Data\CategoryInterface[]|null
     */
    public function getCategories($onlyEnabled = true)
    {
        try {
            if ($onlyEnabled) {
                $searchCriteria = $this->searchCriteriaBuilder->addFilter('status', 1, 'eq');
            }

            $searchCriteria = $this->searchCriteriaBuilder->create();
            $categories = $this->categoryRepository->getList($searchCriteria);
            return $categories->getItems();
        } catch (\Exception $e) {
            $this->_logger->critical($e);
            return null;
        }
    }

    /**
     * getCategoryUrl
     * @param int $categoryId
     * @return string
     */
    public function getCategoryUrl($categoryId)
    {
        $path = $this->_storeManager->getStore()->getBaseUrl();
        return $path . "news/category/view/id/{$categoryId}";
    }
}
