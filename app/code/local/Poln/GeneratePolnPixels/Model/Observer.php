<?php
/**
 * Our class name should follow the directory structure of
 * our Observer.php model, starting from the namespace,
 * replacing directory separators with underscores.
 */
class Poln_GeneratePolnPixels_Model_Observer
{
    /**
     * Magento passes a Varien_Event_Observer object as
     * the first parameter of dispatched events.
     */
    public function generatePixelsScript(Varien_Event_Observer $observer)
    {
        $controller = $observer->getAction();
        $fullActionName = $controller->getFullActionName();

        if($fullActionName == "catalog_product_view")
        {
            $product = Mage::registry('current_product');
            // Embed pixel lookup JS.
            $type = $product->getType();
            $price = $product->getPrice();
            $layout = $controller->getLayout();
            $block = $layout->createBlock('core/text');
            $block->setText('<script type="text/javascript" src="//apps.poln.co/Scripts/magento.js"></script><script type="text/javascript">POLN.init(["'.$type.'", "'.$price.'"]);jQuery(document).ready(function () { POLN.load(); });</script>');
            $layout->getBlock('before_body_end')->append($block);
        }
    }
}
