<?php


namespace Ithappens\Pickup\Controller\Adminhtml\Stores;

use Ithappens\Pickup\Controller\Adminhtml\RegistryConstants;
use Magento\Framework\Controller\ResultFactory;

class Delete extends StoreBase
{
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $formKeyIsValid = $this->_formKeyValidator->validate($this->getRequest());
        $isPost = $this->getRequest()->isPost();
        if (!$formKeyIsValid || !$isPost)
        {
            $this->messageManager->addError(__('Store could not be deleted.'));

            return $resultRedirect->setPath('ithappens_pickup/stores/index');
        }

        $storeId = $this->_initCurrentItem();
        if (!empty($storeId))
        {
            try
            {
                $store = $this->storesFactory->create()->load($storeId);
                $store->delete();
                $this->messageManager->addSuccess(__('You deleted the store.'));
            }
            catch (\Exception $exception)
            {
                $this->messageManager->addError($exception->getMessage());
            }
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('ithappens_pickup/stores/index');
    }

}

