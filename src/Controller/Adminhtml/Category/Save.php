<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Controller\Adminhtml\Category;

use Gugliotti\News\Api\CategoryRepositoryInterface;
use Gugliotti\News\Model\Category;
use Gugliotti\News\Model\CategoryFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;

/**
 * Class Save
 *
 * Gugliotti News Backend Category Save Controller.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Controller\Adminhtml\Category
 */
class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Gugliotti_News::category_save';

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param CategoryFactory $categoryFactory
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->dataPersistor = $dataPersistor;
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
        $data = $this->getRequest()->getParams();

        // get ID and prepare object
        $id = $this->getRequest()->getParam('category_id');

        // prepare status value
        if (
            array_key_exists('status', $data)
            && $data['status'] === true
        ) {
            $data['status'] = Category::STATUS_ENABLED;
        }

        try {
            if ($id) {
                // load the object
                $category = $this->categoryRepository->getById($id);
                if (!$category || !$category->getId()) {
                    $this->messageManager->addErrorMessage(__('This category no longer exists.'));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                $data['category_id'] = null;
                $category = $this->categoryFactory->create();
            }

            $category->setData($data);
            $this->categoryRepository->save($category);
            $this->dataPersistor->clear('gugliotti_news_category');

            // set success message
            $this->messageManager->addSuccessMessage(__('The category has been successfully saved.'));

            // if Save and Continue
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['category_id' => $category->getId(), '_current' => true]);
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was an error when preparing the category.'));
            $resultRedirect = $this->resultRedirectFactory->create();
        }
        return $resultRedirect->setPath('*/*/');
    }
}
