<?php
namespace Ithappens\Quote\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Price implements OptionSourceInterface
{

public function toOptionArray()
{
    return [
        ['value' => 'product', 'label' => __('Product')],
        ['value' => 'cart', 'label' => __('Cart')]
    ];
}

}

