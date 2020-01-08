<?php


namespace Ithappens\Pickup\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Actions extends Column
{

protected $urlBuilder;

protected $controllerName;

public function __construct(
    ContextInterface $context,
    UiComponentFactory $uiComponentFactory,
    UrlInterface $urlBuilder,
    array $components = [],
    array $data = []
)
{
    $this->urlBuilder = $urlBuilder;

    parent::__construct($context, $uiComponentFactory, $components, $data);
}

public function prepareDataSource(array $dataSource)
{
    $primaryFieldName = $this->context->getDataProvider()->getPrimaryFieldName();
    if (isset($dataSource['data']['items']))
    {
        $storeId = $this->context->getFilterParam('store_id');

        foreach ($dataSource['data']['items'] as & $item)
        {
            $item[$this->getData('name')]['edit'] = [
                'href' => $this->urlBuilder->getUrl(
                    "ithappens_pickup/{$this->controllerName}/edit",
                    ['id' => $item[$primaryFieldName], 'store' => $storeId]
                ),
                'label' => __('Edit'),
                'hidden' => false,
            ];
        }
    }

    return $dataSource;
}

}

