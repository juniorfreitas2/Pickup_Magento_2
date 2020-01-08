<?php
namespace Ithappens\Quote\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Quote extends AbstractDb
{

protected function _construct()
{
    $this->_init('ithappens_quote', 'id');
}

}

