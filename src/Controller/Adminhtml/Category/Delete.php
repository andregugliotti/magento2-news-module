<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Controller\Adminhtml\Category;

use Gugliotti\News\Api\CategoryRepositoryInterface;
use Gugliotti\News\Model\CategoryFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

/**
 * Class Delete
 *
 * Gugliotti News Backend Category Delete Controller.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Controller\Adminhtml\Categories
 */
class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Gugliotti_News::category_delete';

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param CategoryFactory $categoryFactory
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        Context $context,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        parent::__construct($context);
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * execute
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        // get ID and prepare object
        $id = $this->getRequest()->getParam('category_id');
        if (!$id) {
            $this->messageManager->addErrorMessage(__('There was an error when processing the request.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        try {
            // load the object
            $category = $this->categoryRepository->getById($id);
            if (!$category || !$category->getId()) {
                $this->messageManager->addErrorMessage(__('This category no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }

            // delete the object
            $this->categoryRepository->delete($category);

            // set success message
            $this->messageManager->addSuccessMessage(__('The category has been successfully deleted.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was an error when preparing the category.'));
            $resultRedirect = $this->resultRedirectFactory->create();
        }
        return $resultRedirect->setPath('*/*/');
    }
}
