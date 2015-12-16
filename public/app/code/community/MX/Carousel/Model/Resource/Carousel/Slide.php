<?php
/**
 * Carousel slide resource model
 *
 * @uses Mage
 * @category Carousel
 * @package  MX_Carousel
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Carousel_Model_Resource_Carousel_Slide
    extends MX_Adminhtml_CustomContent_Model_Resource_Db
{
    protected function _construct()
    {
        $this->_init('mx_carousel/carousel_slide', 'slide_id');
    }

}
