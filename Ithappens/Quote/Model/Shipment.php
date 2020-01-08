<?php
namespace Ithappens\Quote\Model;

use Magento\Framework\Model\AbstractModel;

class Shipment extends AbstractModel
{

protected function _construct()
{
    $this->_init('Ithappens\Quote\Model\Resource\Shipment');
}

}