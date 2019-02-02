<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model\ResourceModel\Category;

use Gugliotti\News\Model\Category;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * Gugliotti News Category Model Collection.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model\ResourceModel\Category
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = Category::ID_FIELD_NAME;

    /**
     * @var string
     */
    protected $_eventPrefix = 'gugliotti_news_category';

    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init(
            'Gugliotti\News\Model\Category',
            'Gugliotti\News\Model\ResourceModel\Category'
        );
    }
}
