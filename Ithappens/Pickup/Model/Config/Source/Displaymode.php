<?php


namespace Ithappens\Pickup\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Displaymode implements OptionSourceInterface
{

public function toOptionArray()
{
    $result = [
        ['value' => 'arrival_date',   'label' => __('Arrival Date')],
        ['value' => 'operation_time', 'label' => __('Operation Time')]
    ];

    return $result;
}

}

