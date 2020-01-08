<?php
namespace Ithappens\Quote\Model;

class Import extends \Magento\Framework\Model\AbstractModel
{

const FALLBACK_URL = 'https://raw.githubusercontent.com/ithappens/fallback-tables/master/';

public function import($tableName)
{
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $dir = $objectManager->get('Magento\Framework\App\Filesystem\DirectoryList');
    $varPath = $dir->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR);

	$fileName = strpos ($tableName, '.json') !== false ? $tableName : $tableName . '.json';
    $data = $this->curl_get_contents (self::FALLBACK_URL . $fileName);

    if ($data && strcmp ($data, 'Not Found'))
    {
		$ithappensVarPath = $varPath . DIRECTORY_SEPARATOR . 'ithappens';
        if (!is_dir ($ithappensVarPath))  mkdir ($ithappensVarPath, 0755, true);

		$filePath = $ithappensVarPath . DIRECTORY_SEPARATOR . $fileName;
		file_put_contents ($filePath, $data);

		if (strcmp ($fileName, 'state_codification'))
        {
			$data = $this->curl_get_contents(self::FALLBACK_URL . 'state_codification.json');

			$filePath = $ithappensVarPath . DIRECTORY_SEPARATOR . 'state_codification.json';
		    file_put_contents ($filePath, $data);
		}
	}
}

public function curl_get_contents ($url)
{
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

    $data = curl_exec($curl);

    curl_close($curl);

    return $data;
}

}

