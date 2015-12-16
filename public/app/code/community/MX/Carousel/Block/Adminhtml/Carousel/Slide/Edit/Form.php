<?php
/**
 * Set up the form for carousel slides
 *
 * @uses Mage
 * @category Carousel
 * @package  MX_Carousel
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Carousel_Block_Adminhtml_Carousel_Slide_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init form
     */
    public function __construct()
    {
        $this->setId('slides_form');
        parent::__construct();
    }

    /**
     * Add the required fields to the form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $helper = $this->_getFormHelper();
        $slideId = $this->_getModel()->getId();

        $form = $helper->createEditForm($this->getData('action'), 'slide_id', $slideId, true);
        $fieldset = $form->addFieldset('slide_fields', array('legend' => 'Slide Details'));

        $helper->addSimpleField($fieldset, 'title', 'Title')
               ->addSimpleField($fieldset, 'sort_order', 'Position')
               ->addSimpleField($fieldset, 'link_url', 'Link URL')
               ->addImageField($fieldset, 'image', 'Image');

        $form->setValues($this->_getModel()->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return MX_Carousel_Model_Carousel_Slide
     */
    protected function _getModel()
    {
        return Mage::registry('slide');
    }

    /**
     * @return MX_Adminhtml_Helper_Form
     */
    protected function _getFormHelper()
    {
        return Mage::helper('mx_adminhtml/form');
    }
}
