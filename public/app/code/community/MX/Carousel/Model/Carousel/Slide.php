<?php
/**
 * Model class for carousel slide
 *
 * @uses Mage
 * @category Carousel
 * @package  MX_Carousel
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Carousel_Model_Carousel_Slide extends Mage_Core_Model_Abstract
{
    /**
     * Initialise the model
     */
    public function _construct()
    {
        $this->_init('mx_carousel/carousel_slide');
    }

    /**
     * Return the image URL for this slide
     *
     * @return string
     */
    public function getImageUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->getImage();
    }

}
