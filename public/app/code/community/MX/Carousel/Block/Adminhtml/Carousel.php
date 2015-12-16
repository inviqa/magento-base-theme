<?php
/**
 * Set up the grid container for carousel slides
 *
 * @uses Mage
 * @category Carousel
 * @package  MX_Carousel
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Carousel_Block_Adminhtml_Carousel extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_blockGroup = 'mx_carousel';
    protected $_controller = 'adminhtml_carousel';
    protected $_headerText = 'Manage Carousel Slides';
    protected $_addButtonLabel = 'Add New Slide';
}
