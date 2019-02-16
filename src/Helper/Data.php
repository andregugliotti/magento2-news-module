<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Data
 *
 * Gugliotti News Main Helper.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Helper
 */
class Data extends AbstractHelper
{
    /**
     * getConfigData
     * @param string $path
     * @param string $scope
     * @return mixed
     */
    public function getConfigData($path, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'gugliotti_news/' . $path,
            $scope
        );
    }

    /**
     * isEnabled
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->getConfigData('general/enabled');
    }

    /**
     * getAllowedFiles
     * @return array
     */
    public function getAllowedFiles()
    {
        $allowedFiles = $this->getConfigData('images_uploader/allowed_files');
        return explode(',', $allowedFiles);
    }
}
