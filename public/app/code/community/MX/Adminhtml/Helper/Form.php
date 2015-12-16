<?php

use Mage_Adminhtml_Block_Widget_Form_Container as FormContainer;

/**
 * Helper for setting up admin forms
 *
 * @category Adminhtml
 * @package MX_Adminhtml
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Adminhtml_Helper_Form
{
    public function addHeaderConfirmButton(FormContainer $formContainer, array $params)
    {
        $label = !empty($params['label']) ? $params['label'] : '';
        $sortOrder = isset($params['sort_order']) ? $params['sort_order'] : 0;

        $formContainer->addButton(
            str_replace(' ', '_', strtolower($label)),
            $params,
            0,
            (int)$sortOrder,
            'header',
            'header'
        );
    }

    /**
     * @param Varien_Data_Form_Element_Fieldset $fieldset
     * @param string $fieldName
     * @param string $label
     * @param string $type
     * @param bool $required
     *
     * @return $this
     */
    public function addSimpleField($fieldset, $fieldName, $label, $type = 'text', $required = true)
    {
        $options = array('name' => $fieldName, 'label' => $label, 'title' => $label);
        if ($required) {
            $options['class'] = 'required-entry';
        }
        $fieldset->addField($fieldName, $type, $options);

        return $this;
    }

    /**
     * @param $fieldset
     * @param $fieldName
     * @param $label
     * @param null|\Zend_Date $defaultDate
     *
     * @return $this
     */
    public function addDateField($fieldset, $fieldName, $label, Zend_Date $defaultDate = null)
    {
        $fieldset->addField(
            $fieldName,
            'date',
            $this->_getDateFormFieldDefaultOptions($fieldName, $label, $defaultDate)
        );

        return $this;
    }

    /**
     * @param $fieldset
     * @param $fieldName
     * @param $label
     * @param null|\Zend_Date $defaultDate
     *
     * @return $this
     */
    public function addDateTimeField($fieldset, $fieldName, $label, Zend_Date $defaultDate = null)
    {
        $dateTimeSpecificOptions = [
            'format' => Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'time' => true
        ];

        $fieldset->addField(
            $fieldName,
            'date',
            $dateTimeSpecificOptions + $this->_getDateFormFieldDefaultOptions($fieldName, $label, $defaultDate)
        );

        return $this;
    }

    /**
     * @param Varien_Data_Form_Element_Fieldset $fieldset
     * @param $label
     *
     * @return $this
     */
    public function addSubmitButton($fieldset, $label)
    {
        $fieldset->addField($label, 'submit', ['value' => $label, 'class' => 'form-button']);

        return $this;
    }

    /**
     * @param Varien_Data_Form_Element_Fieldset $fieldset
     * @param string $fieldName
     * @param string $label
     *
     * @return $this
     */
    public function addImageField($fieldset, $fieldName, $label)
    {
        $fieldset->addField(
            $fieldName,
            'image',
            array('name' => $fieldName, 'label' => $label, 'title' => $label)
        );
        return $this;
    }

    /**
     * @param Varien_Data_Form_Element_Fieldset $fieldset
     * @param string $fieldName
     * @param string $label
     * @param bool $checked
     *
     * @return $this
     */
    public function addCheckboxField($fieldset, $fieldName, $label, $checked = false)
    {
        $fieldset->addField(
            $fieldName,
            'checkbox',
            array('name' => $fieldName, 'label' => $label, 'title' => $label, 'checked' => $checked)
        );
        return $this;
    }

    /**
     * Create the default form and assign the id of this item to a hidden field
     *
     * @param $action
     * @param string $idFieldName
     * @param int $id
     * @param bool $multipart
     *
     * @return Varien_Data_Form
     */
    public function createEditForm($action, $idFieldName, $id = null, $multipart = false)
    {
        $formAttributes = array(
            'id' => 'edit_form',
            'action' => $action,
            'method' => 'post'
        );
        if ($multipart) {
            $formAttributes['enctype'] = 'multipart/form-data';
        }
        $form = new Varien_Data_Form($formAttributes);
        if (!is_null($id)) {
            $form->addField($idFieldName, 'hidden', array('name' => $idFieldName));
        }
        return $form;
    }

    private function _getDateFormFieldDefaultOptions($fieldName, $label, $defaultDate)
    {
        if (is_null($defaultDate)) {
            $defaultDate = new Zend_Date();
        }

        return [
            'name' => $fieldName,
            'label' => $label,
            'format' => Mage::app()->getLocale()->getDateFormatWithLongYear(),
            'image' => Mage::getDesign()->getSkinUrl('images', ['_area' => 'adminhtml']) . '/grid-cal.gif',
            'value' => $defaultDate
        ];
    }
}
