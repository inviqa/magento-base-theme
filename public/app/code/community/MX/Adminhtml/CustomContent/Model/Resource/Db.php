<?php
/**
 * Custom content resource to ensure update times are set on save
 *
 * @uses Mage
 * @category Adminhtml
 * @package  MX_Adminhtml
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
abstract class MX_Adminhtml_CustomContent_Model_Resource_Db
    extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Set created and last updated dates when saving
     *
     * @param Mage_Core_Model_Abstract $model
     * @return $this
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $model)
    {
        Mage::helper('mx_adminhtml')->addUpdatedTime($model);
        return parent::_beforeSave($model);
    }

}
