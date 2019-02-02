<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model\Block\Source;

use Gugliotti\News\Model\Category;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class CategoryStatus
 *
 * Status Selector
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model\Block\Source
 */
class CategoryStatus implements OptionSourceInterface
{
    /**
     * @var \Gugliotti\News\Model\Category
     */
    protected $object;

    /**
     * Constructor
     *
     * @param Category $object
     */
    public function __construct(Category $object)
    {
        $this->object = $object;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->object->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
