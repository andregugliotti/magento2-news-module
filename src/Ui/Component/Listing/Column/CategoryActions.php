<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Ui\Component\Listing\Column;

use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class CategoryActions
 *
 * Gugliotti News Category Ui Component.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Ui\Component\Listing\Column
 */
class CategoryActions extends Column
{
    /**
     * URL_EDIT
     */
    const URL_EDIT = 'gugliotti_news/category/edit';

    /**
     * URL_DELETE
     */
    const URL_DELETE = 'gugliotti_news/category/delete';

    /**
     * @var UrlBuilder
     */
    protected $urlBuilder;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * CategoryActions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $urlBuilder
     * @param UrlInterface $url
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $urlBuilder,
        UrlInterface $url,
        Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->url = $url;
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * prepareDataSource
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        // if not items, return
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        // loop every item to build the actions menu
        foreach($dataSource['data']['items'] as & $item) {
            // don't change the name, it's the key for "actions"
            $name = $this->getData('name');

            // build the actions data according with the entity
            if (isset($item['category_id'])) {
                $item[$name]['edit'] = array(
                    'href' => $this->url->getUrl(self::URL_EDIT, ['category_id' => $item['category_id']]),
                    'label' => __('Edit')
                );

                $label = $this->escaper->escapeHtml($item['label']);
                $item[$name]['delete'] = array(
                    'href' => $this->url->getUrl(self::URL_DELETE, ['category_id' => $item['category_id']]),
                    'label' => __('Delete'),
                    'confirm' => array(
                        'title' => __("Delete Category"),
                        'message' => __("Are you sure you want to delete the record <b>%1</b>?", $label)
                    ),
                );
            }

            if (isset($item['category_id'])) {
                $item[$name]['preview'] = array(
                    'href' => $this->urlBuilder->getUrl(
                        'news/category/view/id/' . $item['category_id'],
                        isset($item['_first_store_id']) ? $item['_first_store_id'] : null,
                        isset($item['store_code']) ? $item['store_code'] : null
                    ),
                    'label' => __('View')
                );
            }
        }
        return $dataSource;
    }
}
