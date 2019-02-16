<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Controller\Adminhtml\Story;

use Gugliotti\News\Helper\Data;
use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class ThumbnailUpload extends Action
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Filesystem $fileSystem
     */
    protected $fileSystem;

    /**
     * @var UploaderFactory $uploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var Data $helper
     */
    protected $helper;

    /**
     * @var LoggerInterface $logger
     */
    protected $logger;

    /**
     * ThumbnailUpload constructor.
     * @param Action\Context $context
     * @param StoreManagerInterface $storeManager
     * @param Filesystem $filesystem
     * @param UploaderFactory $uploaderFactory
     * @param Data $helper
     * @param LoggerInterface $logger
     */
    public function __construct(
        Action\Context $context,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        Data $helper,
        LoggerInterface $logger
    ) {
        $this->storeManager = $storeManager;
        $this->fileSystem = $filesystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->helper = $helper;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        // prepare tmp folder
        try {
            $mediaFolder = $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA);
            $destinationFolder = $mediaFolder->getAbsolutePath($this->helper->getConfigData('images_uploader/folder'));
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $destinationUrl = $mediaUrl . $this->helper->getConfigData('images_uploader/folder');
        } catch (\Exception $e) {
            $this->logger->critical($e);
            throw new LocalizedException(
                __('The destination folder could not be prepared.')
            );
        }

        // process file
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => 'thumbnail_path']);
            $uploader->setAllowedExtensions($this->helper->getAllowedFiles());
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);

            $result = $uploader->save($destinationFolder);

            if (!$result) {
                throw new LocalizedException(
                    __('File can not be saved to the destination folder.')
                );
            }

            $result['url'] =  $destinationUrl . $result['file'];
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $this->logger->critical($e);
            throw new LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        $jsonResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $jsonResult->setData($result);
    }
}
