<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Category
 *
 * Gugliotti News Category Model.
 *
 * @method string getCode()
 * @method setCode(\string $code)
 * @method string getLabel()
 * @method setLabel(\string $label)
 * @method boolean getStatus()
 * @method setStatus(\int $status)
 * @method string getCreatedAt()
 * @method string getUpdatedAt()
 * @method setUpdatedAt(\string $updatedAt)
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model
 */
class Category extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'gugliotti_news_category';

    /**
     * @var string
     */
    protected $_eventObject = 'category';

    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('Gugliotti\News\Model\ResourceModel\Category');
    }
}
