<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Controller\Adminhtml\Story;

use Gugliotti\News\Api\StoryRepositoryInterface;
use Gugliotti\News\Model\Story;
use Gugliotti\News\Model\StoryFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;

/**
 * Class Save
 *
 * Gugliotti News Backend Story Save Controller.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.2.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Controller\Adminhtml\Story
 */
class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Gugliotti_News::story_save';

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var StoryFactory
     */
    protected $storyFactory;

    /**
     * @var StoryRepositoryInterface
     */
    protected $storyRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param StoryFactory $storyFactory
     * @param StoryRepositoryInterface $storyRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        StoryFactory $storyFactory,
        StoryRepositoryInterface $storyRepository
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->dataPersistor = $dataPersistor;
        $this->storyFactory = $storyFactory;
        $this->storyRepository = $storyRepository;
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
        $id = $this->getRequest()->getParam('story_id');

        // prepare status value
        if (
            array_key_exists('status', $data)
            && $data['status'] === true
        ) {
            $data['status'] = Story::STATUS_ENABLED;
        }

        try {
            if ($id) {
                // load the object
                $story = $this->storyRepository->getById($id);
                if (!$story || !$story->getId()) {
                    $this->messageManager->addErrorMessage(__('This story no longer exists.'));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                $data['story_id'] = null;
                $story = $this->storyFactory->create();
            }

            $story->setData($data);

            // if thumbnail uploaded file is set, use the first one, as at this moment, only one thumbnail is allowed
            $story->setThumbnailPath(null);
            if (isset($data['thumbnail_path'][0]['name'])) {
                $story->setThumbnailPath($data['thumbnail_path'][0]['name']);
            }

            if (isset($data['thumbnail_path'][0]['file'])) {
                $story->setThumbnailPath($data['thumbnail_path'][0]['file']);
            }

            $this->storyRepository->save($story);
            $this->dataPersistor->clear('gugliotti_news_story');

            // set success message
            $this->messageManager->addSuccessMessage(__('The story has been successfully saved.'));

            // if Save and Continue
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['story_id' => $story->getId(), '_current' => true]);
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was an error when preparing the story.'));
            $resultRedirect = $this->resultRedirectFactory->create();
        }
        return $resultRedirect->setPath('*/*/');
    }
}
