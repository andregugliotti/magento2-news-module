<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Block\Category;

use Gugliotti\News\Api\CategoryRepositoryInterface;
use Gugliotti\News\Api\StoryRepositoryInterface;
use Gugliotti\News\Helper\Data;
use Gugliotti\News\Model\ResourceModel\Category as CategoryResource;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

/**
 * Class View
 *
 * Gugliotti News Category View Block.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Block\Category
 */
class View extends Template
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
     * @var StoryRepositoryInterface
     */
    protected $storyRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * View constructor.
     * @param Template\Context $context
     * @param CategoryResource $categoryResource
     * @param CategoryRepositoryInterface $categoryRepository
     * @param StoryRepositoryInterface $storyRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Data $helper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CategoryResource $categoryResource,
        CategoryRepositoryInterface $categoryRepository,
        StoryRepositoryInterface $storyRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Data $helper,
        array $data = []
    ) {
        $this->categoryResource = $categoryResource;
        $this->categoryRepository = $categoryRepository;
        $this->storyRepository = $storyRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * getCategoryStories
     * @param int|null $id
     * @return \Gugliotti\News\Api\Data\StoryInterface[]|null
     */
    public function getCategoryStories($id = null)
    {
        // get ID from params if null
        if (!$id) {
            $id = $this->_request->getParam('id');
        }

        // prepare search criteria
        try {
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('category_id', $id, 'eq')
                ->create();
            $collection = $this->storyRepository->getList($searchCriteria);
            return $collection->getItems();
        } catch (\Exception $e) {
            $this->_logger->critical($e);
            return null;
        }
    }

    /**
     * getThumbnailSrc
     * @param string $thumbnailPath
     * @return string
     */
    public function getThumbnailSrc($thumbnailPath)
    {
        $path = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .
            $this->helper->getConfigData('images_uploader/folder');
        return $path . $thumbnailPath;
    }

    /**
     * getStoryUrl
     * @param int $storyId
     * @return string
     */
    public function getStoryUrl($storyId)
    {
        $path = $this->_storeManager->getStore()->getBaseUrl();
        return $path . "news/story/view/id/{$storyId}";
    }

    /**
     * getBackLink
     * @return string
     */
    public function getBackLink()
    {
        $path = $this->_storeManager->getStore()->getBaseUrl();
        return $path . "news/category";
    }
}
