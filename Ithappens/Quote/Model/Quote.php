<?php
namespace Ithappens\Quote\Model;

use Magento\Framework\Model\AbstractModel;

class Quote extends AbstractModel
{

protected function _construct()
{
    $this->_init('Ithappens\Quote\Model\Resource\Quote');
}

}

