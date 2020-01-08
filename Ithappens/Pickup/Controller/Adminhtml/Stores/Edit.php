<?php

namespace Ithappens\Pickup\Controller\Adminhtml\Stores;

class Edit extends StoreBase
{

    public function execute()
    {
        $storeId = $this->_initCurrentItem();
        $storeData = null;
        $store = null;

        $isExistingStore = (bool) $storeId;
        if ($isExistingStore)
        {
            try
            {
                $store = $this->storesFactory->create()->load($storeId);
                $storeData = $store->getData();

                $storeData['entity_id'] = $storeId;
            }
            catch (NoSuchEntityException $e)
            {
                $this->messageManager->addException($e, __('Something went wrong while editing the store.'));

                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('ithappens_pickup/stores/index');

                return $resultRedirect;
            }
        }

        $this->_getSession()->setIntelipostPickupStoreData($storeData);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ithappens_Pickup::istores');

        if ($isExistingStore)
        {
            $resultPage->getConfig()->getTitle()->prepend($store->getName());
        }
        else
        {
            $resultPage->getConfig()->getTitle()->prepend(__('New Store'));
        }

        return $resultPage;
    }

}

