<?php
/*
 * @package     Ithappens_Pickup
 * @copyright   Copyright (c) 2016 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 */

namespace Ithappens\Pickup\Controller\Adminhtml\Stores;

use Magento\Framework\Controller\ResultFactory;

class MassDelete extends \Ithappens\Pickup\Controller\Adminhtml\Stores
{

protected $redirectUrl = 'ithappens_pickup/stores/index';

public function execute()
{
    try
    {
        die();
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        return $this->massAction($collection);
    }
    catch (\Exception $e)
    {
        $this->messageManager->addError($e->getMessage());

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath($this->redirectUrl);
    }
}

protected function massAction(\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $collection)
{
    $storesDeleted = 0;
    foreach ($collection->getAllIds() as $storeId)
    {
        $store = $this->storesFactory->create()->load($storeId);
        $store->delete();
        $storesDeleted++;
    }

    if ($storesDeleted)
    {
        $this->messageManager->addSuccess(__('A total of %1 record(s) were deleted.', $storesDeleted));
    }

    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
    $resultRedirect->setPath($this->getComponentRefererUrl());

    return $resultRedirect;
}

protected function getComponentRefererUrl()
{
    return $this->filter->getComponentRefererUrl()?: 'ithappens_pickup/stores/index';
}

}

