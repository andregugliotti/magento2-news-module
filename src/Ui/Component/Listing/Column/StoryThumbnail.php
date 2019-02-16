<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Ui\Component\Listing\Column;

use Gugliotti\News\Helper\Data;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class StoryThumbnail
 *
 * Gugliotti News Story Thumbnail Ui Component.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Ui\Component\Listing\Column
 */
class StoryThumbnail extends Column
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Repository
     */
    protected $assets;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * StoryThumbnail constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManager
     * @param Repository $assets
     * @param Data $helper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        Repository $assets,
        Data $helper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->assets = $assets;
        $this->helper = $helper;
    }

    /**
     * prepareDataSource
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $placeholderPath = $this->assets->getUrl('Gugliotti_News::images/no-image.png');
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $thumbnailUrl = $mediaUrl . $this->helper->getConfigData('images_uploader/folder');
        $field = 'thumbnail';

        // loop data source and adds image data
        foreach ($dataSource['data']['items'] as & $it) {
            $it["{$field}_alt"] = $it['title'];
            $it["{$field}_src"] = $thumbnailUrl . $it['thumbnail_path'];
            $it["{$field}_orig_src"] = $thumbnailUrl . $it['thumbnail_path'];

            // insert placeholder if null
            if (!isset($it['thumbnail_path']) || !$it['thumbnail_path']) {
                $it["{$field}_src"] = $placeholderPath;
                $it["{$field}_orig_src"] = $placeholderPath;
            }
        }
        return $dataSource;
    }
}
