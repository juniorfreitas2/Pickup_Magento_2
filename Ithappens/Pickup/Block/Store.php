<?php


namespace Ithappens\Pickup\Block;

class Store extends \Magento\Framework\View\Element\Template
{

public function __construct(
    \Magento\Framework\View\Element\Template\Context $context
)
{
    $this->setTemplate('store.phtml');

    parent::__construct($context);
}

public function getAjaxStoreUrl()
{
    return $this->getUrl('Ithappens_Pickup/store/index');
}

}

