<?php


namespace Ithappens\Pickup\Controller\Adminhtml\Stores;

use Ithappens\Pickup\Controller\Adminhtml\RegistryConstants;

abstract class StoreBase  extends \Magento\Backend\App\Action
{
    protected $coreRegistry;

    protected $filter;

    protected $resultForwardFactory;

    protected $resultPageFactory;

    protected $storesFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Ithappens\Pickup\Model\StoresFactory $storesFactory,
        \Ithappens\Pickup\Model\Resource\Stores\CollectionFactory $collectionFactory
    )
    {
        $this->coreRegistry = $coreRegistry;
        $this->filter = $filter;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;

        $this->storesFactory = $storesFactory;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context);
    }

    protected function _initCurrentItem()
    {
        $itemId = $this->getRequest()->getParam('id');

        if ($itemId) {
            $this->coreRegistry->register(RegistryConstants::CURRENT_ITHAPPENS_PICKUP_ITEM_ID, $itemId);
        }

        return $itemId;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ithappens_Pickup::istores');
    }
}