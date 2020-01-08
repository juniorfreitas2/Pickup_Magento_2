<?php


namespace Ithappens\Pickup\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ResetButton extends GenericButton implements ButtonProviderInterface
{

public function getButtonData()
{
    $data = [
        'label' => __('Reset'),
        'class' => 'reset',
        'id' => 'item-edit-reset-button',
        'on_click' => 'location.reload();',
        'sort_order' => 30
    ];

    return $data;
}

}

