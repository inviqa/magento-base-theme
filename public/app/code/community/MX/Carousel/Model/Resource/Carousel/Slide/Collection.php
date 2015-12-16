<?php
/**
 * Resource collection for carousel slides
 *
 * @uses Mage
 * @category Carousel
 * @package  MX_Carousel
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Carousel_Model_Resource_Carousel_Slide_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     * Initialise the collection
     */
    public function _construct()
    {
        $this->_init('mx_carousel/carousel_slide');
        parent::_construct();
    }

}
