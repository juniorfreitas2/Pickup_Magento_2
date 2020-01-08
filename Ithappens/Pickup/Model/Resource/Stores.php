<?php


namespace Ithappens\Pickup\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Stores extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('ithappens_pickup_stores', 'entity_id');
    }

}

