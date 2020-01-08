<?php


namespace Ithappens\Pickup\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface
{

public function getButtonData()
{
    $data = [
        'label' => __('Save and Continue Edit'),
        'class' => 'save',
        'data_attribute' => [
            'mage-init' => [
                'button' => ['event' => 'saveAndContinueEdit'],
            ],
        ],
        'sort_order' => 80,
    ];

    return $data;
}

}

