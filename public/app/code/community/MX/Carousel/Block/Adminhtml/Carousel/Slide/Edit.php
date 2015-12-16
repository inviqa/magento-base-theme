<?php
/**
 * Set up the form container for carousel slides
 *
 * @uses Mage
 * @category Carousel
 * @package  MX_Carousel
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Carousel_Block_Adminhtml_Carousel_Slide_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected $_objectId = 'slide_id';
    protected $_controller = 'adminhtml_carousel_slide';
    protected $_blockGroup = 'mx_carousel';

    /**
     * Initialise the container with save and delete buttons
     */
    public function __construct()
    {
        parent::__construct();
        $this->_updateButton('save', 'label', 'Save Slide');
        $this->_updateButton('delete', 'label', 'Delete Slide');
    }

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('slide')->getId()) {
            return "Edit Slide '" . Mage::registry('slide')->getTitle() . "'";
        }
        return 'New Slide';
    }

    /**
     * Get form action URL
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('*/carousel/save');
    }
}
