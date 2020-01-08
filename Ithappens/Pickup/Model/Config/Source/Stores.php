<?php


namespace Ithappens\Pickup\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Stores implements OptionSourceInterface
{

public function toOptionArray()
{
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $collection = $objectManager->create('Ithappens\Pickup\Model\Resource\Stores\Collection');

    $result = array ();

    foreach ($collection as $child)
    {
        $result [] = ['value' => $child->getId(), 'label' => $child->getName ()];
    }

    return $result;
}

}

