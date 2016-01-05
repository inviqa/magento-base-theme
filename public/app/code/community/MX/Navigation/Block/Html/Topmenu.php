<?php
/**
 * MX_Navigation_Block_Html_Topmenu
 *
 * @copyright Session Digital 2015
 * @package  MX_Navigation
 * @author Katie Fenn <kfenn@sessiondigital.com>
 */
class MX_Navigation_Block_Html_Topmenu extends Mage_Page_Block_Html_Topmenu
{
    /**
     * Build the menu HTML
     *
     * @param Varien_Data_Tree_Node  $menuTree  Tree structure to menu
     * @param string  $childrenWrapClass  Class to wrap in children div
     *
     * @return string
     */
    protected function _getHtml(Varien_Data_Tree_Node $menuTree, $childrenWrapClass)
    {
        $html = '';

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = is_null($parentLevel) ? 0 : $parentLevel + 1;

        $counter = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        foreach ($children as $child) {

            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel == 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $child->setClass($outermostClass);
            }

            $blockName = ($childLevel == 0) ? 'topMenu.topLevel' : 'topMenu.subLevel';

            $block = Mage::app()->getLayout()->getBlock($blockName);
            $block->setMenu($child);
            $block->setOutermostClassCode($outermostClassCode);
            $block->setChildrenWrapClass($childrenWrapClass);
            $block->setChildLevel($childLevel);
            $block->setIsFirst($counter == 1);
            $block->setIsLast($counter == $childrenCount);
            $html .= $block->toHtml();

            $counter++;
        }

        return $html;
    }
}