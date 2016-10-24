<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Model_Banner extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		$this->_init('ibanners/banner');
	}
	
	/**
	 * Retrieve the group model associated with the banner
	 *
	 * @return Fishpig_iBanners_Model_Group|false
	 */
	public function getGroup()
	{
		if (!$this->hasGroup()) {
			$this->setGroup($this->getResource()->getGroup($this));
		}
		
		return $this->getData('group');
	}
	
	/**
	 * Determine whether the banner has a valid URL
	 *
	 * @return bool
	 */
	public function hasUrl()
	{
		return strlen($this->getUrl()) > 1;
	}

	/**
	 * Retrieve the image URL
	 *
	 * @return string
	 */
	public function getImageUrl()
	{
		if (!$this->hasImageUrl()) {
			$this->setImageUrl(Mage::helper('ibanners/image')->getImageUrl($this->getImage()));
		}
		
		return $this->getData('image_url');
	}

        /**
	 * Retrieve the image mobile URL
	 *
	 * @return string
	 */
	public function getImageMobileUrl()
	{
		if (!$this->hasImageMobileUrl()) {
			$this->setImageMobileUrl(Mage::helper('ibanners/image')->getImageMobileUrl($this->getImageMobile()));
		}
		
		return $this->getData('image_mobile_url');
	}
        
	/**
	 * Retrieve the URL
	 * This converts relative URL's to absolute
	 *
	 * @return string
	 */
	public function getUrl()
	{
		if ($this->_getData('url')) {
			if (strpos($this->_getData('url'), 'http://') === false && strpos($this->_getData('url'), 'https://') === false) {
				return $this->setUrl(Mage::getBaseUrl() . ltrim($this->_getData('url'), '/ '));
			}
            
            return $this->_getData('url');
		}
		        
        if ($this->_getData('category')) {
            $category = Mage::getModel('catalog/category')->load($this->_getData('category'));
            
            return $category->getUrl();
        }
        
        return '';
	}
}
