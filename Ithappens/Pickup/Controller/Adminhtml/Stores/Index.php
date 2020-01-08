<?php


namespace Ithappens\Pickup\Controller\Adminhtml\Stores;

class Index extends StoreBase
{

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu('Ithappens_Pickup::istores');

        $resultPage->getConfig()->getTitle()->prepend(__('Manage Stores'));

        $resultPage->addBreadcrumb(__('Manage Stores'), __('Manage Pickup Stores'));

        return $resultPage;
    }

}

