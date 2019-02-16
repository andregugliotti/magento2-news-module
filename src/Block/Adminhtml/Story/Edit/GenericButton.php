<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Block\Adminhtml\Story\Edit;

use Gugliotti\News\Api\StoryRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Psr\Log\LoggerInterface;

/**
 * Class GenericButton
 *
 * Gugliotti News Backend Buttons.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.2.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Block\Adminhtml\Story\Edit\GenericButton
 * @see \Magento\Cms\Block\Adminhtml\Page\Edit\GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var StoryRepositoryInterface
     */
    protected $storyRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param StoryRepositoryInterface $storyRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        StoryRepositoryInterface $storyRepository,
        LoggerInterface $logger
    ) {
        $this->context = $context;
        $this->storyRepository = $storyRepository;
        $this->logger = $logger;
    }

    /**
     * getStoryId
     * @return int|null
     */
    public function getStoryId()
    {
        try {
            return $this->storyRepository->getById(
                $this->context->getRequest()->getParam('story_id')
            )->getId();
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
        return null;
    }

    /**
     * getUrl
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
