<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Block\Adminhtml\Story\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 *
 * Gugliotti News Backend Buttons.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.2.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Block\Adminhtml\Story\Edit\SaveButton
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * getButtonData
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Story'),
            'class' => 'save primary',
            'data-attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save'
            ],
            'sort_order' => 90
        ];
    }
}
