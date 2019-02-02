<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model;

use Gugliotti\News\Api\Data\CategoryInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Category
 *
 * Gugliotti News Category Model.
 *
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model
 */
class Category extends AbstractModel implements IdentityInterface, CategoryInterface
{
    /**
     * News Category cache tag
     */
    const CACHE_TAG = 'news_category';

    /**
     * ID_FIELD_NAME
     */
    const ID_FIELD_NAME = 'category_id';

    /**#@+
     * Category statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_idFieldName = self::ID_FIELD_NAME;

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

    /**
     * getIdentities
     * @return array
     */
    public function getIdentities()
    {
        return [
            self::CACHE_TAG . '_' . $this->getId(),
            self::CACHE_TAG . '_' . $this->getCode()
        ];
    }

    /**
     * getAvailableStatuses
     *
     * Provides a list of available status for this entity.
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_DISABLED => __('Disabled')
        ];
    }

    /**
     * getCode
     * @return mixed|string
     */
    public function getCode()
    {
        return $this->getData('code');
    }

    /**
     * setCode
     * @param string $code
     * @return $this|mixed
     */
    public function setCode($code)
    {
        return $this->setData('code', $code);
    }

    /**
     * getLabel
     * @return mixed|string
     */
    public function getLabel()
    {
        return $this->getData('label');
    }

    /**
     * setLabel
     * @param string $label
     * @return $this|mixed
     */
    public function setLabel($label)
    {
        return $this->setData('label', $label);
    }

    /**
     * getStatus
     * @return mixed|string
     */
    public function getStatus()
    {
        return $this->getData('status');
    }

    /**
     * setStatus
     * @param string $status
     * @return $this|mixed
     */
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    /**
     * getCreatedAt
     * @return mixed|string
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * setCreatedAt
     * @param string $createdAt
     * @return $this|mixed
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData('created_at', $createdAt);
    }

    /**
     * getUpdatedAt
     * @return mixed|string
     */
    public function getUpdatedAt()
    {
        return $this->getData('updated_at');
    }

    /**
     * setUpdatedAt
     * @param string $updatedAt
     * @return $this|mixed
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData('updated_at', $updatedAt);
    }
}
