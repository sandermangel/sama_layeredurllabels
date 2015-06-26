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

class Sama_LayeredUrlLabels_Block_Adminhtml_System_Attributes extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    public function _prepareToRender()
    {
        $this->addColumn('attribute', array(
            'label' => Mage::helper('sama_layeredurllabels')->__('Attribute code'),
            'style' => 'width:100px',
            //'renderer' => new Sama_LayeredUrlLabels_Block_Adminhtml_System_Config_Form_Field_Select_Attributes()
        ));
        $this->addColumn('options', array(
            'label' => Mage::helper('sama_layeredurllabels')->__('Options (empty for all)'),
            'style' => 'width:100px'
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('sama_layeredurllabels')->__('Add');
    }
}