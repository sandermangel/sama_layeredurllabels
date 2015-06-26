<?php
/**
 * Sama_LayeredUrlLabels extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Sama
 * @package        Sama_LayeredUrlLabels
 * @copyright      Copyright (c) 2015
 * @author         Sander Mangel <sander@sandermangel.nl>
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */

class Sama_LayeredUrlLabels_Block_Adminhtml_System_Config_Form_Field_Select_Attributes extends Mage_Adminhtml_Block_Abstract
{
    protected function _toHtml()
    {
        $column = $this->getColumn();

        $optionsHtml = '';
        $attributes = Mage::getResourceModel('catalog/product_attribute_collection')
            ->getItems();

        foreach ($attributes as $_attribute) {
            if (!$_attribute->usesSource()) continue;

            $optionsHtml .= '<option value="' . $_attribute->getAttributecode() . '">' . $_attribute->getAttributecode() . '</option>';
        }

        return '<select name="' . $this->getInputName() . '" value="#{' . $this->getColumnName() . '}" ' .
            ($column['size'] ? 'size="' . $column['size'] . '"' : '') . ' class="' .
            (isset($column['class']) ? $column['class'] : 'input-text') . '"'.
            (isset($column['style']) ? ' style="'.$column['style'] . '"' : '') . '>' . $optionsHtml . '</select>';
    }
}