<?php
/*
 * @package     Ithappens_Pickup
 * @copyright   Copyright (c) 2016 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 */

namespace Ithappens\Pickup\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Config;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Psr\Log\LoggerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;

class Pickup extends AbstractCarrier implements  CarrierInterface
{

    protected $_code = 'pickup';

    protected $_rateResultFactory;
    protected $_rateMethodFactory;
    protected $_rateErrorFactory;

    protected $_scopeConfig;
    protected $_quoteHelper;
    protected $_apiHelper;
    protected $_pickupHelper;

    protected $_itemsFactory;
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductRepository $productRepo,
        \Ithappens\Pickup\Model\StoresFactory $itemsFactory,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        \Ithappens\Pickup\Helper\Data $pickupHelper,
        array $data = []
    ){
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_productRepo = $productRepo;
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->_storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;

        $this->_itemsFactory = $itemsFactory;
        $this->_pickupHelper = $pickupHelper;

        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    public function getAllowedMethods()
    {
        return ['pickup' => $this->getConfigData ('name')];
    }
//

    public function collectRates(RateRequest $request, $pickup = true)
    {

        if(!$this->getConfigFlag('active')){
            return false;
        }
        $result = $this->_rateResultFactory->create();

        $min_pdt_date =  $this->getMinDate($request);
//        if (!$min_pdt_date) return false;

        $destPostcode = preg_replace ('#[^0-9]#', "", $request->getDestPostcode());

        $collection = $this->_itemsFactory->create()->getCollection ();

        $collection->getSelect()->where("is_active = 1  AND ('{$destPostcode}' BETWEEN begin_zipcode AND end_zipcode)");

        $showAllStores = $this->_scopeConfig->getValue('carriers/pickup/show_all_stores');

        if (!$collection->count()) return false;

        $carrierTitle = $this->_scopeConfig->getValue('carriers/pickup/title');

        foreach($collection as $item)
        {
            $storeId = $item ['id_loja'] /* $item->getStoreId() */;

//            /*
//             * Delivered by CDG
//             */
//            if (!$item ['store_delivered_cdg'] /* ->getStoreDeliveredCdg() */ && !$showAllStores)
//            {
//                $request->setPickupDestPostcode ($item['store_zipcode'] /* ->getStoreZipcode() */);
//
//                $result = parent::collectRates($request, true);
//
//                $this->_pickupHelper->checkFreeshipping ($result);
//
//                return $result;
//            }

            /*
             * Config
             */
            $methodTitle = $this->_pickupHelper->getCustomTitle($item);

            /*
             * Method
             */
            $method = $this->_rateMethodFactory->create();

            $method->setCarrier($this->_code);
            $method->setCarrierTitle($carrierTitle);

            $method->setMethod($this->_code . '_' . $storeId);
            $method->setMethodTitle($methodTitle);
            $method->setMethodDescription($methodTitle);

            $method->setPrice(0);
            $method->setCost(0);

            $result->append($method);

//            if($sortByProximity && strcmp($pageName, 'checkout')) break;
        }

        return $result;
    }
//
//public function getMinDate(RateRequest $request)
//{
//    $parentItem = null;
//
//    // Product Factory
//    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//    $objectProduct = $objectManager->get('Magento\Catalog\Model\ProductFactory');
//
//    $preSalesAttribute = $this->_scopeConfig->getValue ('carriers/presales/presales_attribute');
//    $packageAttribute = $this->_scopeConfig->getValue ('carriers/presales/package_attribute');
//    $readyToGoAttribute = $this->_scopeConfig->getValue ('carriers/presales/readytogo_attribute');
//
//    $dateFormat = $this->_scopeConfig->getValue ('carriers/pickup/date_format');
//
//    foreach ($request->getAllItems () as $item)
//    {
//        if ($item->getProductType() != 'simple')
//        {
//            $parentItem = $item;
//
//            continue;
//        }
//
//        $product = $objectProduct->create()->load ($item->getProductId ());
//
//        $preSalesValue = $product->getData($preSalesAttribute);
//        $preSalesReady = $product->getData($readyToGoAttribute);
//        $packageValue  = $product->getData($packageAttribute);
//
//        if ($preSalesValue && !$preSalesReady && !$packageValue)
//        {
//            return false;
//
//            if ($parentItem)
//            {
//                $preSalesItems [$preSalesValue][] = $parentItem;
//            }
//
//            $preSalesItems [$preSalesValue][] = $item;
//        }
//    }
//
//    $preSalesResult = null;
//
//    return date($dateFormat, $this->_quoteHelper->getShippedDate(false));
//}

}

