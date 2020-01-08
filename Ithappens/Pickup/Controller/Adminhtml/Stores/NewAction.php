<?php


namespace Ithappens\Pickup\Controller\Adminhtml\Stores;

class NewAction extends StoreBase
{
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        $resultForward->forward('edit');

        return $resultForward;
    }

}

