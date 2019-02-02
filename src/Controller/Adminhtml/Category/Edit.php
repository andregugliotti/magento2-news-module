<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Controller\Adminhtml\Category;

use Gugliotti\News\Api\CategoryRepositoryInterface;
use Gugliotti\News\Model\CategoryFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 *
 * Gugliotti News Backend Category Edit Controller.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Controller\Adminhtml\Categories
 */
class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Gugliotti_News::category_save';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * Edit constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     * @param CategoryFactory $categoryFactory
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * execute
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Gugliotti_News::content_news_category');
        $resultPage->addBreadcrumb(__('CMS'), __('CMS'));
        $resultPage->addBreadcrumb(__('News'), __('News'));
        $resultPage->getConfig()->getTitle()->prepend(__('News Categories'));

        // get ID and prepare object
        $id = $this->getRequest()->getParam('category_id');
        try {
            if ($id) {
                // load the object
                $category = $this->categoryRepository->getById($id);
                if (!$category || !$category->getId()) {
                    $this->messageManager->addErrorMessage(__('This category no longer exists.'));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
                $resultPage->addBreadcrumb(__('Edit Category'), __('Edit Category'));
            } else {
                $category = $this->categoryFactory->create();
                $resultPage->addBreadcrumb(__('Add Category'), __('Add Category'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was an error when preparing the category.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        // build edit form
        $this->coreRegistry->register('gugliotti_news_category', $category);
        return $resultPage;
    }
}
