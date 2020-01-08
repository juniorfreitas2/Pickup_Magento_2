<?php


namespace Ithappens\Pickup\Model\Stores;

use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\Api\Search\SearchResultInterface;

class Reporting implements ReportingInterface
{

public function search(SearchCriteriaInterface $searchCriteria)
{
    $collection = $this->collectionFactory->getReport($searchCriteria->getRequestName());
    $collection->setPageSize($searchCriteria->getPageSize());
    $collection->setCurPage($searchCriteria->getCurrentPage());
    $this->filterPool->applyFilters($collection, $searchCriteria);

    foreach ($searchCriteria->getSortOrders() as $sortOrder)
    {
        if ($sortOrder->getField())
        {
            $collection->setOrder($sortOrder->getField(), $sortOrder->getDirection());
        }
    }

    return $collection;
}

}

