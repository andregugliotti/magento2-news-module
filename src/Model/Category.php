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
class Category extends AbstractModel implements CategoryInterface, IdentityInterface
{
    /**
     * News Category cache tag
     */
    const CACHE_TAG = 'news_category';

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
}
