<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model\ResourceModel\Story;

use Gugliotti\News\Model\Story;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * Gugliotti News Story Model Collection.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.2.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model\ResourceModel\Story
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = Story::ID_FIELD_NAME;

    /**
     * @var string
     */
    protected $_eventPrefix = 'gugliotti_news_story';

    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init(
            'Gugliotti\News\Model\Story',
            'Gugliotti\News\Model\ResourceModel\Story'
        );
    }
}
