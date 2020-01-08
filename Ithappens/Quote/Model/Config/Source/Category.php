<?php
namespace Ithappens\Quote\Model\Config\Source;

class Category extends \Magento\Catalog\Model\Config\Source\Category
{

public function toOptionArray($addEmpty = false)
{
    /** @var \Magento\Catalog\Model\ResourceModel\Category\Collection $collection */
    $collection = $this->_categoryCollectionFactory->create();

    $collection->addAttributeToSelect('name');
        // ->addRootLevelFilter()
        // ->load();
    $collection->getSelect()->where('level != 0');

    $options = [];

    foreach ($collection as $category)
    {
        $level = intval ($category->getLevel ());
        $preffix = $level > 1 ? str_repeat (' - ', $level - 1) : null;
        $options[] = ['label' => $preffix . $category->getName(), 'value' => $category->getId()];
    }

    return $options;
}

}

