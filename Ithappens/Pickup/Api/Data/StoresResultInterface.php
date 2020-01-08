<?php


namespace Ithappens\Pickup\Api\Data;

class StoresResultInterface
{

protected $stores;

/**
 * Get stores list.
 *
 * @api
 * @return \Ithappens\Pickup\Api\Data\StoresResultInterface[]
 */
public function getStores()
{
    return $this->stores;
}

/**
 * Set stores list.
 *
 * @api
 * @param \Ithappens\Pickup\Api\Data\StoresResultInterface[] $stores
 * @return $this
 */
public function setStores(array $stores = null)
{
    $this->stores = $stores;

    return $this;
}

}

