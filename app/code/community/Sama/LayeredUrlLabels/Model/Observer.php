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

class Sama_LayeredUrlLabels_Model_Observer
{
    /**
     * Listen to the controller_action_predispatch_catalog_category_layered event
     *
     * @param Varien_Event_Observer $o
     */
    public function controllerActionPredispatchCatalogCategoryView($o)
    {
        $this->_paramLabelsToIds($o);

        return $this;
    }

    /**
     * Listen to the core_block_abstract_to_html_before event
     *
     * @param Varien_Event_Observer $o
     */
    public function coreBlockAbstractToHtmlBefore($o)
    {
        $this->_setPageMeta($o);

        return $this;
    }

    /**
     * Get labels per param and translate to ID
     *
     * @param Varien_Event_Observer $o
     */
    protected function _paramLabelsToIds($o)
    {
        $params = Mage::app()->getRequest()->getParams();
        ksort($params, SORT_REGULAR);

        $_product = Mage::getModel('catalog/product');

        /**
         * Settings for checking if a robots tag has to be set
         */
        $setRobots = Mage::getStoreConfigFlag('sama_layeredurllabels/robots/active');
        $robotAttributes = (string)Mage::getStoreConfig('sama_layeredurllabels/robots/attributes');
        $robotAttributes = unserialize($robotAttributes);
        $allowedAttributes = array();
        foreach ((array)$robotAttributes as $attribute) {
            if (!isset($allowedAttributes[$attribute['attribute']]))
                $allowedAttributes[$attribute['attribute']] = array();

            $allowedAttributes[$attribute['attribute']][] = $attribute['options'];
        }
        $robots = true;

        foreach ($params as $code => $label) {
            //if (is_numeric($label)) continue; // already ID so skip <-- this could actually give false positive on int as label
            $_attribute = $_product->getResource()->getAttribute($code);

            if (!$_attribute) { // is not a valid attribute
                unset($params[$code]);
                continue;
            }
            if (!$_attribute->usesSource()) continue; // is not a select / multiselect

            $optionId = $_attribute->getSource()->getOptionId($label);

            if ((int)$optionId) {
                Mage::app()->getRequest()->setParam($code, $optionId);
            }

            $isSet = array_key_exists($_attribute->getId(), $allowedAttributes);
            $setLabel = (isset($allowedAttributes[$_attribute->getAttributecode()])) ? $allowedAttributes[$_attribute->getAttributecode()] : array() ;
            if (!$isSet && (!in_array($label, $setLabel) || !count($setLabel))) {
                $robots = false;
            }
        }

        if ($setRobots) {
            Mage::register('_layeredurllabels_setrobots', $robots ? 'index,follow' : 'noindex,nofollow');
        }

        return $this;
    }

    /**
     * Set the robots and canonical tag
     *
     * @param Varien_Event_Observer $o
     */
    protected function _setPageMeta($o)
    {
        $setRobots = Mage::getStoreConfigFlag('sama_layeredurllabels/robots/active');
        $block = $o->getBlock();
        if($block instanceof Mage_Page_Block_Html_Head && $setRobots) {
            $block->setData('robots', Mage::registry('_layeredurllabels_setrobots'));
        }

        return $this;
    }
}