<?php


namespace Ithappens\Pickup\Model\Resource\Stores;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

protected function _construct()
{
    $this->_init(
        'Ithappens\Pickup\Model\Stores',
        'Ithappens\Pickup\Model\Resource\Stores'
    );
}

}

