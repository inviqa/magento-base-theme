<?php
/**
 * Adminhtml controller with common custom content functionality
 *
 * @uses Mage
 * @category Adminhtml
 * @package  MX_Adminhtml
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
abstract class MX_Adminhtml_CustomContent_Controller_Action
    extends Mage_Adminhtml_Controller_Action
{
    protected $_activeMenu;
    protected $_itemName = 'Item';
    protected $_itemIdFieldName = 'id';

    /**
     * Set up common variables for individual actions
     * @param string|null $pageTitle
     * @return $this
     */
    protected function _initAction($pageTitle = null)
    {
        $this->loadLayout();
        $this->_setActiveMenu($this->_activeMenu);
        $this->_setSectionTitle();
        if (!is_null($pageTitle)) {
            $this->_title($pageTitle);
        }
        return $this;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed($this->_activeMenu);
    }

    /**
     * Index action to show the configured grid
     */
    public function indexAction()
    {
        $this->_initAction();
        $this->_addContent($this->_getIndexBlock());
        $this->renderLayout();
    }

    /**
     * New action, this simply builds the edit form without data
     */
    public function newAction()
    {
        $this->_initAction('New ' . $this->_getItemName());
        $this->_renderEditForm();
    }

    /**
     * Edit action to set up the form used when editing or creating an item
     */
    public function editAction()
    {
        $this->_initAction('Edit ' . $this->_getItemName());

        //Check that the item exists before trying to edit it
        $id = $this->_getRequestId();
        if (!$this->_itemExists($id)) {
            return $this->_addItemDoesNotExistError();
        }
        $this->_renderEditForm($id);
    }

    /**
     * Save action to save the new or edited items
     */
    public function saveAction()
    {
        $id = $this->_getRequestId();
        $data = $this->getRequest()->getPost();

        if (!$this->_canSaveItem($id, $data)) {
            return $this->_addItemDoesNotExistError();
        }
        try {
            $this->_saveItem($id, $data);
            $this->_saveSuccessful();
        } catch (Exception $e) {
            $this->_saveFailed($e, $data);
        }
    }

    /**
     * Delete action to remove items
     */
    public function deleteAction()
    {
        $id = $this->_getRequestId();
        if (!$this->_itemExists($id)) {
            return $this->_addItemDoesNotExistError();
        }

        try {
            $this->_deleteItem($id);
            $this->_deleteSuccessful();
        } catch (Exception $e) {
            $this->_deleteFailed($e);
        }
    }

    /**
     * @param int|null $id
     */
    protected function _renderEditForm($id = null)
    {
        // Restore entered data if recovering from an error
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        $this->_registerItem($id, $data ?: []);

        $this->_addContent($this->_getEditFormBlock());
        $this->renderLayout();
    }

    /**
     * Get the item id to use for this request
     * @return int
     */
    protected function _getRequestId()
    {
        return $this->getRequest()->getParam($this->_itemIdFieldName);
    }

    /**
     * @param integer $id
     * @param $data
     * @return bool
     */
    protected function _canSaveItem($id, array $data)
    {
        return !empty($data) && (empty($id) || $this->_itemExists($id));
    }

    /**
     * Return the name of the item
     * @param bool $lowercase
     * @return string
     */
    protected function _getItemName($lowercase = false)
    {
        if ($lowercase) {
            return strtolower($this->_itemName);
        }
        return $this->_itemName;
    }

    /**
     * Add error message to the session if item does not exist
     */
    protected function _addItemDoesNotExistError()
    {
        Mage::getSingleton('adminhtml/session')->addError(
            'This ' . $this->_getItemName(true) . ' no longer exists.'
        );
        $this->_redirect('*/*/');
    }

    /**
     * Add success message
     */
    protected function _deleteSuccessful()
    {
        Mage::getSingleton('adminhtml/session')->addSuccess(
            'The ' . $this->_getItemName(true) . ' has been deleted.'
        );
        $this->_redirect('*/*/');
    }

    /**
     * Add error message and redirect to the edit page
     *
     * @param Exception $exception
     */
    protected function _deleteFailed(Exception $exception)
    {
        $this->_actionFailed($exception);
    }

    /**
     * Add success message and clear form data now the slide has been saved
     */
    protected function _saveSuccessful()
    {
        Mage::getSingleton('adminhtml/session')->addSuccess(
            'The ' . $this->_getItemName(true) . ' has been saved.'
        );
        Mage::getSingleton('adminhtml/session')->setFormData([]);
        $this->_redirect('*/*/');
    }

    /**
     * Add error message and set the save data to the session to be reloaded into the form
     *
     * @param Exception $exception
     * @param array $data
     */
    protected function _saveFailed(Exception $exception, array $data)
    {
        Mage::getSingleton('adminhtml/session')->setFormData($data);
        $this->_actionFailed($exception);
    }

    /**
     * Add error message and redirect when save or delete action fails
     * @param Exception $exception
     */
    protected function _actionFailed(Exception $exception)
    {
        Mage::getSingleton('adminhtml/session')->addError($exception->getMessage());
        $this->_redirect('*/*/edit', array($this->_itemIdFieldName => $this->_getRequestId()));
    }

    /**
     * Set up the section title
     */
    abstract protected function _setSectionTitle();
    /**
     * Get the index page content block
     */
    abstract protected function _getIndexBlock();
    /**
     * Get the edit form content block
     */
    abstract protected function _getEditFormBlock();
    /**
     * Check that the provided item id is a valid item
     */
    abstract protected function _itemExists($id);
    /**
     * Delete the item based on its id
     * @param integer $id
     */
    abstract protected function _deleteItem($id);
    /**
     * Save the current item based on its id
     * @param integer $id
     */
    abstract protected function _saveItem($id, array $data);
    /**
     * Build and add the item to magento registry
     * @param int $id
     * @param array $data
     */
    abstract protected function _registerItem($id, array $data);

}
