<?php
/*
 * @package     Ithappens_Pickup
 * @copyright   Copyright (c) 2016 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 */

namespace Ithappens\Pickup\Observer\Sales;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Ithappens\Quote\Model\Quote;

class OrderSaveAfter implements ObserverInterface
{

protected $_pickupStores;
protected $_pickupItems;

protected $_ithappensHelper;
protected $_ithappensQuote;
protected $_sessionManager;

public function __construct(
    \Ithappens\Pickup\Model\Stores $pickupStores,
    \Ithappens\Quote\Helper\Data $ithappensHelper,
    \Ithappens\Quote\Model\Quote $ithappensQuote,
    \Magento\Framework\Session\SessionManager $sessionManager
)
{
    $this->_pickupStores = $pickupStores;
    //$this->_pickupItems = $pickupItems;

    $this->_ithappensHelper = $ithappensHelper;
    $this->_ithappensQuote = $ithappensQuote;
    $this->_sessionManager = $sessionManager;
}

public function execute(Observer $observer)
{
    $sessionId = $this->_sessionManager->getSessionId ();
    $orderInstance = $observer->getOrder();
    $result = null;

    $shippingMethod = explode('_', $orderInstance->getShippingMethod());
    if(!empty($shippingMethod[0]) && !strcmp($shippingMethod[0], 'pickup') /* carrierName */
        && !empty($shippingMethod[1]) && !strcmp($shippingMethod[1], 'pickup') /* methodName */
        && !empty($shippingMethod[2]) /* pickupStoreId */
    )
    {
        $pickupStoreId = $shippingMethod[2];

        $resultQuotes = array();

        $ithappensQuoteCollection = $this->_ithappensHelper->getResultQuotes(\Ithappens\Quote\Helper\Data::RESULT_PICKUP);
        foreach($ithappensQuoteCollection as $quote)
        {
            if($quote->getCarrier() == 'pickup' && $quote->getDeliveryMethodId() == $pickupStoreId /* && $quote->getOrderId() == null */)
            {
                $resultQuotes [] = $quote;
            }
        }

        if (empty($ithappensQuoteCollection) && !count($ithappensQuoteCollection) /* !$ithappensQuoteCollection->count() */) return;

        $pickupStore = $this->_pickupStores->load($pickupStoreId);

        $result ['store'] = $pickupStore->getData();

        $orderInstance->getShippingAddress()
            // ->setAddressType('store')
            // ->setFirstname($pickupStore->getName())
            // ->setLastname('')
            ->setStreet(array(
                $pickupStore->getAddress(),
                $pickupStore->getNumber(),
                $pickupStore->getComplement(),
                $pickupStore->getStoreNeighborhood() // $pickupStore->getDistrict()
            ))
            ->setPostcode($pickupStore->getZipcode())
            ->setCity($pickupStore->getCity())
            ->setRegion($pickupStore->getState())
            ->save();

        // $pickupStoreItem = $this->_pickupItems->load($pickupStoreId, 'store_id');

        $pickupStoreItem = $this->_pickupItems->load($ithappensQuoteCollection[0]->getQuoteId(), 'entity_id');

        $result ['item'] = $pickupStoreItem->getData();
    }

    $orderInstance->setIthappensPickup(
        json_encode($result)
    )->save();
}

}

