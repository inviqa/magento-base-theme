<?php
/**
 * Block class to create the carousel from saved slides
 *
 * @uses Mage
 * @category Carousel
 * @package  MX_Carousel
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Carousel_Block_Carousel extends Mage_Core_Block_Template
{

    public function _construct()
    {
        $this->setTemplate('mx/carousel/carousel.phtml');
        parent::_construct();
    }

    /**
     * Get the slides that form the carousel in the required order
     *
     * @return MX_Carousel_Model_Resource_Carousel_Slide_Collection
     */
    public function getSlides()
    {
        return Mage::getModel('mx_carousel/carousel_slide')
                   ->getCollection()
                   ->addOrder('sort_order', 'asc');
    }
}
