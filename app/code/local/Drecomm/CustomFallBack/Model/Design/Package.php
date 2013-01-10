<?php
/**
 * Overrides the class Mage_Core_Model_Design_Package
 * @category    Drecomm
 * @package     Drecomm_CustomFallBack
 * @author      Drecomm
 */
class Drecomm_CustomFallback_Model_Design_Package extends Mage_Core_Model_Design_Package {

    /**
     * Override the _fallback method
     * @param string $file
     * @param array &$params
     * @param array $fallbackScheme
     * @return string
     */
    protected function _fallback($file, array &$params, array $fallbackScheme = array(array())) {

        $fallback = trim(Mage::getStoreConfig('drecomm_costumfallback/general/fallback'));
        $themes = explode(',',$fallback);

        if (!empty($themes)){
            foreach( $themes as $theme){
                $custom = array('_theme' => $theme);
                array_push($fallbackScheme ,$custom);
            }
        }

        if ($this->_shouldFallback) {
            foreach ($fallbackScheme as $try) {
                $params = array_merge($params, $try);
                $filename = $this->validateFile($file, $params);
                if ($filename) {
                    return $filename;
                }
            }
            $params['_package'] = self::BASE_PACKAGE;
            $params['_theme']   = self::DEFAULT_THEME;
        }
        return $this->_renderFilename($file, $params);
    }
}
?>
