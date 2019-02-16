<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Model\Block\Source;

use Gugliotti\News\Model\Story;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class StoryStatus
 *
 * Status Selector
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.2.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Model\Block\Source
 */
class StoryStatus implements OptionSourceInterface
{
    /**
     * @var \Gugliotti\News\Model\Story
     */
    protected $object;

    /**
     * Constructor
     *
     * @param Story $object
     */
    public function __construct(Story $object)
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
