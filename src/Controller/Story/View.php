<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Controller\Story;

use Gugliotti\News\Helper\Data;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class View
 *
 * Gugliotti News Story View Controller.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Controller\Story
 */
class View extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var $helper
     */
    protected $helper;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Data $helper
    ) {
        $this->pageFactory = $pageFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // verify if this module is enabled and redirect to home
        if (!$this->helper->isEnabled()) {
            return $this->_redirect('/');
        }

        // create page and adds a title
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set((__('News | Story')));
        return $page;
    }
}
