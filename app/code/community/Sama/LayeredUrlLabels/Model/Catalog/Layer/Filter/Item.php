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

class Sama_LayeredUrlLabels_Model_Catalog_Layer_Filter_Item extends Mage_Catalog_Model_Layer_Filter_Item
{
    /**
     * Get filter item url
     *
     * @return string
     */
    public function getUrl()
    {
        $query = array(
            $this->getFilter()->getRequestVar()=>$this->getLabel(), // <-- getLabel is the only change
            Mage::getBlockSingleton('page/html_pager')->getPageVarName() => null // exclude current page from urls
        );
        return Mage::getUrl('*/*/*', array('_current'=>true, '_use_rewrite'=>true, '_query'=>$query));
    }
}