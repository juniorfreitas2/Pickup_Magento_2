<?php

namespace Ithappens\Quote\Model\Quote;

class Plugin
{
	public function afterGetGroupedAllShippingRates($subject, $result)
	{
        $scheduledIndex = 0;
        $scheduled = null;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $scopeConfig = $objectManager->create('Magento\Framework\App\Config\ScopeConfigInterface');

        $ag_title = $scopeConfig->getValue("carriers/ithappens/scheduled_title");
        $ag_last  = $scopeConfig->getValue("carriers/ithappens/scheduled_last");

        if (!$ag_last) return $result;

        foreach ($result as $value) 
        {
            foreach($value as $c => $v)
            {
                if ($v->getMethodTitle() == $ag_title)
                {
                    $scheduled = $v;
                    $scheduledIndex = $c ? $c : 0;    
                }
            }
            
        }

        if ($scheduled)
        {
            unset($result['ithappens'][$scheduledIndex]);
            array_push($result['ithappens'], $scheduled);
        }

        return $result;
	}
}

