<?php


namespace Ithappens\Pickup\Controller\Adminhtml\Stores;

use Ithappens\Pickup\Controller\Adminhtml\RegistryConstants;

class Save  extends StoreBase
{
    public function execute()
    {
        $returnToEdit = false;
        $originalRequestData = $this->getRequest()->getPostValue();
        $storeId = isset($originalRequestData['item']['id'])
            ? $originalRequestData['item']['id']
            : null;
        if ($originalRequestData)
        {
            try
            {
                if ($storeId)
                {
                    $store = $this->storesFactory->create()->load($storeId);
                }
                else
                {
                    $store = $this->storesFactory->create();
                }

                $store->addData($originalRequestData['item']);
                $store->save();

                $this->_getSession()->unsIntelipostPickupStoresData();

                $storeId = $store->getId();
                $this->coreRegistry->register(RegistryConstants::CURRENT_ITHAPPENS_PICKUP_ITEM_ID, $storeId);

                $this->messageManager->addSuccess(__('You saved the store.'));

                $returnToEdit = (bool) $this->getRequest()->getParam('back', false);
            }
            catch (\Magento\Framework\Validator\Exception $exception)
            {
                $messages = $exception->getMessages();
                if (empty($messages))
                {
                    $messages = $exception->getMessage();
                }

                $this->_addSessionErrorMessages($messages);
                $this->_getSession()->setCustomerData($originalRequestData);

                $returnToEdit = true;
            }
            catch (LocalizedException $exception)
            {
                $this->_addSessionErrorMessages($exception->getMessage());

                $this->_getSession()->setIntelipostPickupData($originalRequestData);

                $returnToEdit = true;
            }
            catch (\Exception $exception)
            {
                $this->messageManager->addException($exception, __('Something went wrong while saving the store.'));

                $this->_getSession()->setIntelipostPickupStoreData($originalRequestData);

                $returnToEdit = true;
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        if ($returnToEdit)
        {
            if ($storeId) {
                $resultRedirect->setPath(
                    'ithappens_pickup/stores/edit',
                    ['id' => $storeId, '_current' => true]
                );
            }
            else
            {
                $resultRedirect->setPath(
                    'ithappens_pickup/stores/new',
                    ['_current' => true]
                );
            }
        }
        else
        {
            $resultRedirect->setPath('ithappens_pickup/stores/index');
        }

        return $resultRedirect;
    }

}

