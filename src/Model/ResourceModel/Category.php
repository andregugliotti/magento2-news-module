<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model\ResourceModel;

use Gugliotti\News\Model\Category as CategoryModel;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Class Category
 *
 * Gugliotti News Category Resource Model.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model\ResourceModel
 */
class Category extends AbstractDb
{
    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @var string
     */
    protected $_idFieldName = CategoryModel::ID_FIELD_NAME;

    /**
     * Category constructor.
     * @param Context $context
     * @param DateTime $dateTime
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        DateTime $dateTime,
        $connectionName = null)
    {
        $this->dateTime = $dateTime;
        parent::__construct($context, $connectionName);
    }

    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('gugliotti_news_category', 'category_id');
    }

    /**
     * Set date of last update for category
     *
     * @param \Gugliotti\News\Model\Category|AbstractModel $object
     * @return \Gugliotti\News\Model\Category $object
     */
    protected function _beforeSave(AbstractModel $object)
    {
        parent::_beforeSave($object);
        $object->setUpdatedAt($this->dateTime->gmtDate());
        return $object;
    }
}
