<?php


namespace Ithappens\Pickup\Api;

interface StoresInterface
{

/**
 * Retrieve stores list
 *
 * @api
 * @return \Ithappens\Pickup\Api\Data\StoresResultInterface
 * @throws \Magento\Framework\Exception\LocalizedException
 */
public function getList();

/**
 * Retrive store information
 *
 * @api
 * @param int $id
 * @return \Ithappens\Pickup\Api\Data\StoresInterface
 * @throws \Magento\Framework\Exception\LocalizedException
 */
public function getInfo($id);

/**
 * Save store information
 *
 * @api
 * @param \Ithappens\Pickup\Api\Data\StoresInterface[] $stores
 * @return bool
 * @throws \Magento\Framework\Exception\LocalizedException
 */
public function saveItem($stores);

/**
 * Delete store
 *
 * @api
 * @param  int $id
 * @return bool
 * @throws \Magento\Framework\Exception\LocalizedException
 */
public function deleteItem($id);

}

