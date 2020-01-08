<?php
namespace Ithappens\Quote\Model\Resource\Quote;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

protected function _construct()
{
    $this->_init(
        'Ithappens\Quote\Model\Quote',
        'Ithappens\Quote\Model\Resource\Quote'
    );
}

}

