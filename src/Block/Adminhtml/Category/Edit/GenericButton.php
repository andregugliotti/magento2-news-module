<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Block\Adminhtml\Category\Edit;

use Gugliotti\News\Api\CategoryRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Psr\Log\LoggerInterface;

/**
 * Class GenericButton
 *
 * Gugliotti News Backend Buttons.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Block\Adminhtml\Category\Edit\GenericButton
 * @see \Magento\Cms\Block\Adminhtml\Page\Edit\GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param CategoryRepositoryInterface $categoryRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        CategoryRepositoryInterface $categoryRepository,
        LoggerInterface $logger
    ) {
        $this->context = $context;
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
    }

    /**
     * getCategoryId
     * @return int|null
     */
    public function getCategoryId()
    {
        try {
            return $this->categoryRepository->getById(
                $this->context->getRequest()->getParam('category_id')
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
