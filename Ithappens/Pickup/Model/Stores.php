<?php
/*
 * @package     Ithappens_Pickup
 * @copyright   Copyright (c) 2016 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 */

namespace Ithappens\Pickup\Model;

use Magento\Framework\Model\AbstractModel;

class Stores extends AbstractModel
{

protected $storesFactory;
protected $storesInterfaceFactory;
protected $storesResultInterfaceFactory;

public function __construct(
    \Magento\Framework\Model\Context $context,
    \Magento\Framework\Registry $registry,
    \Ithappens\Pickup\Model\StoresFactory $storesFactory,
    \Ithappens\Pickup\Api\Data\StoresInterfaceFactory $storesInterfaceFactory,
    \Ithappens\Pickup\Api\Data\StoresResultInterfaceFactory $storesResultInterfaceFactory
)
{
    $this->storesFactory = $storesFactory;
    $this->storesInterfaceFactory = $storesInterfaceFactory;
    $this->storesResultInterfaceFactory = $storesResultInterfaceFactory;

    parent::__construct($context, $registry);
}

protected function _construct()
{
    $this->_init('Ithappens\Pickup\Model\Resource\Stores');
}

/*
 * {@inheritdoc}
 */
public function getList()
{
    $collection = $this->getCollection();
    $data = null;

    foreach ($collection as $child)
    {
        $data [] = $child->getData();
    }

    $result = $this->storesResultInterfaceFactory->create();
    $result->setStores($data);

    return $result;
}

/*
 * {@inheritdoc}
 */
public function getInfo($id)
{
    $object = $this->storesFactory->create()->load($id);

    $result = $this->storesInterfaceFactory->create();
    $result->setId($object->getId());
    $result->setIdLoja($object->getIdLoja());
    $result->setName($object->getName());
    $result->setAddress($object->getAddress());
    $result->setNumber($object->getNumber());
    $result->setComplement($object->getComplement());
    $result->setZipcode($object->getZipcode());
    $result->setCity($object->getCity());
    $result->setState($object->getState());
    $result->setStoreNeighborhood($object->getStoreNeighborhood());
    $result->setOpening($object->getOpening());
    $result->setBeginZipcode($object->getBeginZipcode());
    $result->setEndZipcode($object->getEndZipcode());
    $result->setObservations($object->getObservations());
    $result->setDeliveredCdg($object->getDeliveredCdg());
    $result->setIsActive($object->getIsActive());

    return $result;
}

/*
 * {@inheritdoc}
 */
public function saveItem($stores)
{
    foreach ($stores as $store)
    {
        $object = $this->storesFactory->create();

        $object->setId ($store->getId());
        $object->setIdLoja($store->getIdLoja());
        $object->setName ($store->getName());
        $object->setAddress ($store->getAddress());
        $object->setNumber ($store->getNumber());
        $object->setState ($store->getState());
        $object->setZipcode ($store->getZipcode());
        $object->setCity ($store->getCity());
        $object->setState ($store->getState());
        $object->setStoreNeighborhood($store->getStoreNeighborhood());
        $object->setOpening ($store->getOpening());
        $object->setBeginZipcode ($store->getBeginZipcode());
        $object->setEndZipcode ($store->getEndZipcode());
        $object->setObservations ($store->getObservations());
        $object->setDeliveredCdg ($store->getDeliveredCdg());
        $object->setIsActive ($store->getIsActive());

        $object->save();
    }

    return true;
}

/*
 * {@inheritdoc}
 */
public function deleteStore($id)
{
    $object = $this->load($id);
    $object->delete();

    return true;
}

}

