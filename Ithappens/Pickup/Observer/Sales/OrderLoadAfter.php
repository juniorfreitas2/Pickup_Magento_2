<?php


namespace Intelipost\Pickup\Observer\Sales;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class OrderLoadAfter implements ObserverInterface
{

public function execute(Observer $observer)
{
    $order = $observer->getOrder();

    $extensionAttributes = $order->getExtensionAttributes();

    if ($extensionAttributes === null)
    {
        $extensionAttributes = $this->getOrderExtensionDependency();
    }

    $ithappensPickup = $order->getData('ithappens_pickup');

    $extensionAttributes->setIntelipostPickup($ithappensPickup);

    $order->setExtensionAttributes($extensionAttributes);
}

private function getOrderExtensionDependency()
{
    $orderExtension = \Magento\Framework\App\ObjectManager::getInstance()->get(
        '\Magento\Sales\Api\Data\OrderExtension'
    );

    return $orderExtension;
}

}

