<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Ui\Component\Listing\Column;

use Magento\Store\Ui\Component\Listing\Column\Store\Options;

/**
 * Class StoreViewOptions
 *
 * Gugliotti News Store View Options Component.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Ui\Component\Listing\Column
 */
class StoreViewOptions extends Options
{
    /**
     * ALL_STORE_VIEWS
     */
    const ALL_STORE_VIEWS = '0';

    /**
     * toOptionArray
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $this->currentOptions['All Store Views']['label'] = __('All Store Views');
        $this->currentOptions['All Store Views']['value'] = self::ALL_STORE_VIEWS;

        $this->generateCurrentOptions();
        $this->options = array_values($this->currentOptions);
        return $this->options;
    }
}
