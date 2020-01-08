<?php
namespace Ithappens\Quote\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Unit implements OptionSourceInterface
{

public function toOptionArray()
{
    return [
        ['value' => 'gr', 'label' => __('Gram')],
        ['value' => 'kg', 'label' => __('Kilo')]
    ];
}

}

