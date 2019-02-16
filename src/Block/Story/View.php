<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Block\Story;

use Gugliotti\News\Api\StoryRepositoryInterface;
use Gugliotti\News\Helper\Data;
use Gugliotti\News\Model\ResourceModel\Story as StoryResource;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

/**
 * Class View
 *
 * Gugliotti News Story View Block.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Block\Story
 */
class View extends Template
{
    /**
     * @var StoryResource
     */
    protected $storyResource;

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
     * @param StoryResource $storyResource
     * @param StoryRepositoryInterface $storyRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Data $helper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        StoryResource $storyResource,
        StoryRepositoryInterface $storyRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Data $helper,
        array $data = []
    ) {
        $this->storyResource = $storyResource;
        $this->storyRepository = $storyRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * getStory
     * @return \Gugliotti\News\Api\Data\StoryInterface|null
     */
    public function getStory()
    {
        $id = $this->_request->getParam('id');

        // prepare search criteria
        try {
            return $this->storyRepository->getById($id);
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
     * @param int|null $categoryId
     * @return string
     */
    public function getBackLink($categoryId = null)
    {
        $path = $this->_storeManager->getStore()->getBaseUrl();
        if ($categoryId) {
            return $path . "news/category/view/id/{$categoryId}";
        }
        return $path . "news/category";
    }
}
