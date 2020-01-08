<?php


namespace Ithappens\Quote\Helper;

class Api
{

const LOG = 'var/log/ithappens.log';

const QUOTE_BY_PRODUCT = 'quote_by_product/';
const QUOTE_BUSINESS_DAYS = 'quote/business_days/';
const QUOTE_AVAILABLE_SCHEDULING_DATES = 'quote/available_scheduling_dates/';

protected $_scopeConfig;
protected $_cache;

public function __construct
(
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    \Magento\Framework\App\CacheInterface $cache,
    \Psr\Log\LoggerInterface $logger
)
{
    $this->_scopeConfig = $scopeConfig;
    $this->_cache = $cache;

    $this->_logger = $logger;
    $this->_logger->pushHandler (new \Monolog\Handler\StreamHandler(str_replace('/', DIRECTORY_SEPARATOR, self::LOG)));

    parent::__construct($scopeConfig);
}

public function quoteRequest ($httpMethod, $apiMethod, & $postData = false)
{
    $postData ['api_request'] = json_encode ($postData);

    $result = null; // $this->getCache ($postData); // Disabled
/*
    if (!empty ($result))
    {
        $postData ['api_response'] = json_encode ($result);

        return $result;
    }
*/
    $response = $this->apiRequest ($httpMethod, $apiMethod, json_encode ($postData));

    $result = json_decode ($response, true);

    if (!$result)
    {
        $result = $this->getContingencyValues ($postData);

        $postData ['api_response'] = json_encode ($result, true);

        return $result;
    }

    if (!strcmp ($result ['status'], 'ERROR'))
    {
        $messages = null;

        foreach ($result ['messages'] as $_message)
        {
            $messages .= $_message ['text'];
        }

        $this->_logger->debug($postData ['destination_zip_code'] . ' : ' . $messages);

        throw new \Exception ($messages);
    }

    $postData ['api_response'] = $response;

    // $this->saveCache ($postData, $result);

    return $result;
}

public function getCacheIdentifier ($postData)
{
    $identifier = 'ithappens_api_'
        . $postData ['destination_zip_code'] . '_'
        . $postData ['cart_weight'] . '_'
        . $postData ['cart_amount'] . '_'
        . $postData ['cart_qtys'];

    return $identifier;
}

public function getCache ($postData)
{
    $identifier = $this->getCacheIdentifier ($postData);

    $result = unserialize ($this->_cache->load ($identifier));

    return $result;
}

public function saveCache ($postData, $responseData)
{
    $identifier = $this->getCacheIdentifier ($postData);
    $lifetime = intval ($this->_scopeConfig->getValue ('carriers/ithappens/cache_exp_time'));

    $result = $this->_cache->save (serialize ($responseData), $identifier, array('collections'), $lifetime);

    return $result;
}

public function getContingencyValues ($postData)
{
    $destZipcode = intval ($postData ['destination_zip_code']);

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $dir = $objectManager->get('Magento\Framework\App\Filesystem\DirectoryList');
    $varPath = $dir->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR);

	$ithappensVarPath = $varPath . DIRECTORY_SEPARATOR . 'ithappens';

    /*
     * calculate State Codification
     */
	$stateFile = $ithappensVarPath . DIRECTORY_SEPARATOR . 'state_codification.json';
	$stateContent = json_decode (file_get_contents ($stateFile), true);

    $stateCode = null;
    $stateType = null;

    foreach ($stateContent [0] as $beginZip => $child)
    {
        if ($destZipcode >= $beginZip && $destZipcode <= $child ['cep_end'])
        {
            $stateCode = strtoupper ($child ['state']);
            $stateType = strtoupper ($child ['type']);

            break;
        }
    }

    /*
     * calculate Contingency Table
     */
    $contingencyTable = $this->_scopeConfig->getValue ('carriers/ithappens/contingency_table');
	$tableFile = $ithappensVarPath . DIRECTORY_SEPARATOR . $contingencyTable;

	$tableContent = json_decode (file_get_contents ($tableFile), true);

    $totalWeight = 0;
    foreach ($postData ['products'] as $product)
    {
        $totalWeight += intval ($product ['weight']);
    }

    $delivery = array(
        'delivery_method_id'     => 'fallback',
        'delivery_method_type'   => 'fallback',
        'provider_shipping_cost' => 0,
    );

    foreach ($tableContent as $stateId => $stateContent)
    {
        if (!strcmp (strtoupper ($stateId), $stateCode))
        {
            foreach ($stateContent as $regionId => $regionContent)
            {
                if (!strcmp (strtoupper ($regionId), $stateType))
                {
                    $delivery ['delivery_estimate_business_days'] = $regionContent ['delivery_estimate_business_days'];

                    foreach ($regionContent ['final_shipping_cost'] as $weight => $price)
                    {
                        if ($totalWeight <= $weight)
                        {
                            $delivery ['final_shipping_cost'] = $price;
                            $delivery ['logistic_provider_name'] = $regionId;
                            $delivery ['description'] = $regionId;
                            $delivery ['delivery_method_name'] = $regionId;

                            break;
                        }
                    }
                }
            }
        }
    }

    $result = array(
        'content' => array(
            'id' => 0,
            'delivery_options' => array ($delivery)
        )
    );

    return $result;
}

public function getEstimateDeliveryDate ($originZipcode, $destPostcode, $businessDays)
{
    $response = $this->apiRequest (self::GET, self::QUOTE_BUSINESS_DAYS
        . "{$originZipcode}/{$destPostcode}/{$businessDays}");

    $result = json_decode ($response, true);

    return $result;
}

public function getAvailableSchedulingDates ($originZipcode, $destPostcode, $deliveryMethodId)
{
    $response = $this->apiRequest (self::GET, self::QUOTE_AVAILABLE_SCHEDULING_DATES
        . "{$deliveryMethodId}/{$originZipcode}/{$destPostcode}");

    $result = json_decode ($response, true);

    return $result;
}

}

