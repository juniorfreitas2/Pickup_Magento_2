<?php


namespace Intelipost\Pickup\Api\Data;

class StoresInterface
{

/**#@+
 * Constants defined for keys of the data array. Identical to the name of the getter in snake case
 */
const ID = 'id';
const ID_LOJA = 'id_loja';
const NAME = 'name';
const ADDRESS = 'address';
const NUMBER = 'number';
const COMPLEMENT = 'complement';
const ZIPCODE = 'zipcode';
const CITY = 'city';
const STATE = 'state';
const STORE_NEIGHBORHOOD = 'store_neighborhood';
const OPENING = 'opening';
const BEGIN_ZIPCODE = 'begin_zipcode';
const END_ZIPCODE = 'end_zipcode';
const OBSERVATIONS = 'observations';
const DELIVERED_CDG = 'delivered_cdg';
const IS_ACTIVE = 'is_active';
/**#@-*/

protected $id;
protected $idLoja;
protected $name;
protected $address;
protected $number;
protected $complement;
protected $zipcode;
protected $city;
protected $state;
protected $storeNeighborhood;
protected $opening;
protected $begin_zipcode;
protected $end_zipcode;
protected $observations;
protected $delivered_cdg;
protected $is_active;

/**
 * Get store id
 *
 * @api
 * @return int|null
 */
public function getId()
{
    return $this->id;
}

/**
 * Set store id
 *
 * @api
 * @param int $id
 * @return $this
 */
public function setId($id)
{
    $this->id = $id;

    return $this;
}

/**
 * Get item id loja
 *
 * @api
 * @return string|null
 */
public function getIdLoja()
{
    return $this->idLoja;
}

/**
 * Set item id loja
 *
 * @api
 * @param string $id
 * @return $this
 */
public function setIdLoja($id)
{
    $this->idLoja = $id;

    return $this;
}

/**
 * Get store name
 *
 * @api
 * @return string|null
 */
public function getName()
{
    return $this->name;
}

/**
 * Set store name
 *
 * @api
 * @param string $name
 * @return $this
 */
public function setName($name)
{
    $this->name = $name;

    return $this;
}

/**
 * Get store address
 *
 * @api
 * @return string|null
 */
public function getAddress()
{
    return $this->address;
}

/**
 * Set store address
 *
 * @api
 * @param string $address
 * @return $this
 */
public function setAddress($address)
{
    $this->address = $address;

    return $this;
}

/**
 * Get store number
 *
 * @api
 * @return string|null
 */
public function getNumber()
{
    return $this->number;
}

/**
 * Set store number
 *
 * @api
 * @param string $number
 * @return $this
 */
public function setNumber($number)
{
    $this->number = $number;

    return $this;
}

/**
 * Get store complement
 *
 * @api
 * @return string|null
 */
public function getComplement()
{
    return $this->complement;
}

/**
 * Set store complement
 *
 * @api
 * @param string $complement
 * @return $this
 */
public function setComplement($complement)
{
    $this->complement = $complement;

    return $this;
}

/**
 * Get store zipcode
 *
 * @api
 * @return string|null
 */
public function getZipcode()
{
    return $this->zipcode;
}

/**
 * Set store zipcode
 *
 * @api
 * @param string $zipcode
 * @return $this
 */
public function setZipcode($zipcode)
{
    $this->zipcode = $zipcode;

    return $this;
}

/**
 * Get store city
 *
 * @api
 * @return string|null
 */
public function getCity()
{
    return $this->city;
}

/**
 * Set store city
 *
 * @api
 * @param string $city
 * @return $this
 */
public function setCity($city)
{
    $this->city = $city;

    return $this;
}

/**
 * Get store neighborhood
 *
 * @api
 * @return string|null
 */
public function getStoreNeighborhood()
{
    return $this->storeNeighborhood;
}

/**
 * Set store Neighborhood
 *
 * @api
 * @param string $neighborhood
 * @return $this
 */
public function setStoreNeighborhood($neighborhood)
{
    $this->storeNeighborhood = $neighborhood;

    return $this;
}

/**
 * Get store state
 *
 * @api
 * @return string|null
 */
public function getState()
{
    return $this->state;
}

/**
 * Set store state
 *
 * @api
 * @param string $state
 * @return $this
 */
public function setState($state)
{
    $this->state = $state;

    return $this;
}

/**
 * Get store opening
 *
 * @api
 * @return string|null
 */
public function getOpening()
{
    return $this->opening;
}

/**
 * Set store opening
 *
 * @api
 * @param string $opening
 * @return $this
 */
public function setOpening($opening)
{
    $this->opening = $opening;

    return $this;
}

/**
 * Get store begin zipcode
 *
 * @api
 * @return string|null
 */
public function getBeginZipcode()
{
    return $this->begin_zipcode;
}

/**
 * Set store begin zipcode
 *
 * @api
 * @param string $zipcode
 * @return $this
 */
public function setBeginZipcode($zipcode)
{
    $this->begin_zipcode = $zipcode;

    return $this;
}

/**
 * Get store end zipcode
 *
 * @api
 * @return string|null
 */
public function getEndZipcode()
{
    return $this->end_zipcode;
}

/**
 * Set store end zipcode
 *
 * @api
 * @param string $zipcode
 * @return $this
 */
public function setEndZipcode($zipcode)
{
    $this->end_zipcode = $zipcode;

    return $this;
}

/**
 * Get store observations
 *
 * @api
 * @return string|null
 */
public function getObservations()
{
    return $this->observations;
}

/**
 * Set store observations
 *
 * @api
 * @param string $observations
 * @return $this
 */
public function setObservations($observations)
{
    $this->observations = $observations;

    return $this;
}

/**
 * Get store is delivered by CDG
 *
 * @api
 * @return string|null
 */
public function getDeliveredCdg()
{
    return $this->delivered_cdg;
}

/**
 * Set store is delivered by CDG
 *
 * @api
 * @param string $delivered_cdg
 * @return $this
 */
public function setDeliveredCdg($delivered_cdg)
{
    $this->delivered_cdg = $delivered_cdg;

    return $this;
}

/**
 * Get store is active
 *
 * @api
 * @return string|null
 */
public function getIsActive()
{
    return $this->is_active;
}

/**
 * Set store is active
 *
 * @api
 * @param string $active
 * @return $this
 */
public function setIsActive($is_active)
{
    $this->is_active = $is_active;

    return $this;
}

}

