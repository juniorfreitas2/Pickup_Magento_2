<?php


namespace Ithappens\Pickup\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

const ARRIVAL_DATE_FIELD = 'arrival_date';
const OPERATION_TIME_FIELD = 'operation_time';

const GOOGLE_MAPS_URL = 'https://www.google.com/maps/embed/v1/place';
const GOOGLE_DISTANCE_MATRIX_URL = 'https://maps.googleapis.com/maps/api/distancematrix/json';

public function getMapsHtml ($store)
{
    $apiKey = $this->scopeConfig->getValue('carriers/pickup/google_maps_api');


    $address = $store->getAddress ();
    $number = $store->getNumber ();
    $city = $store->getCity ();

    $result = self::GOOGLE_MAPS_URL . '?key=' . $apiKey . '&q=' . str_replace (chr (32), '+', $address . '+' . $number . '+' . $city);

$result = <<< RESULT
    <div id="ithappens-pickup-map">
    <iframe class="embed-responsive-item" width="270" height="270" frameborder="0" style="border:0" src="{$result}"></iframe>
    <br />
    {$store->getOpening()}
    </div>
RESULT;

    return $result;
}

public function checkFreeshipping (& $rates)
{
    $lowerPrice = PHP_INT_MAX;
    $lowerMethod = null;

    $oldRates = clone $rates;
    $rates->reset ();

    foreach ($oldRates->getAllRates () as $_rate)
    {
        $price = $_rate->getPrice();
        $method = $_rate->getMethod ();

        if ($price < $lowerPrice)
        {
            $lowerPrice = $price;
            $lowerMethod = $method;
        }
    }

    foreach ($oldRates->getAllRates () as $_rate)
    {
        $price = $_rate->getPrice();
        $method = $_rate->getMethod ();

        if (!strcmp ($lowerMethod, $method))
        {
            $newRate = clone $_rate;
            // $newRate->setMethodTitle ($_rate->getCarrierTitle()); // FIXED
            $newRate->setPrice (0);

            $rates->append ($newRate);

            break;
        }
    }
}

public function getCustomTitle ($item)
{
    //implement this
    /*
     * Config
     */
    $displayMode = $this->scopeConfig->getValue ('carriers/pickup/display_mode');
    $displayTitle = $item[$displayMode] /* $item->getData($displayMode) */;

    $additionalSLA = intval($this->scopeConfig->getValue ('carriers/pickup/additional_sla'));

//    if (!strcmp($displayMode, self::ARRIVAL_DATE_FIELD))
//    {
//        $dateFormat = $this->scopeConfig->getValue ('carriers/pickup/date_format');
//
//        $timestamp = \DateTime::createFromFormat('!' . $dateFormat, $displayTitle)->getTimestamp();
//        $deliveryTitle = date ('d/m/Y', $timestamp);
//    }
//    else if (!strcmp ($displayMode, self::OPERATION_TIME_FIELD))
//    {
//        $deliveryTitle = intval($displayTitle) + $additionalSLA;
//    }

    $customTitle = $this->scopeConfig->getValue ('carriers/pickup/custom_title');
    $carrierTitle = $item['name'] /* ->getStoreName() */;

//    $methodTitle = sprintf($customTitle, $carrierTitle, $deliveryTitle);

    return $carrierTitle;//$methodTitle;
}

public function calculateDistanceMatrix ($origins, $destinations)
{
    $apiKey = $this->scopeConfig->getValue ('carriers/pickup/google_maps_api');

    $apiUrl = self::GOOGLE_DISTANCE_MATRIX_URL
        . '?origins=' . $origins . '&destinations=' . implode('|', $destinations) . '&key=' . $apiKey;

    $curl = curl_init ();

    curl_setopt($curl, CURLOPT_TIMEOUT, 3);
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_ENCODING , "");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec ($curl);

    curl_close ($curl);

    return $response;
}

}

