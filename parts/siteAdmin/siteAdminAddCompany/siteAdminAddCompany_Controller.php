<?php
ob_start();
require '../../../vendor/autoload.php';

include '../../header.php';
ob_end_clean();

use Itrack\Anaf\Client;
use Itrack\Anaf\Exceptions\LimitExceeded;
use Itrack\Anaf\Exceptions\RequestFailed;
use Itrack\Anaf\Exceptions\ResponseFailed;

giveAccess();

date_default_timezone_set('Europe/Bucharest');

$reqSuccess = 1;
$requestANAF = new Client();
$cif = $_POST['cif'];
$currentDate = date('Y-m-d');
$requestANAF->addCif($cif, $currentDate);
$company = null;
try {
    $company = $requestANAF->first();
} catch (LimitExceeded|RequestFailed|ResponseFailed $e) {
    $reqSuccess = 2;
}
$companyData = [
    'name' => $company->getName(),
    'registration_code' => $company->getCIF(),
    'phone' => $company->getPhone(),
    'full_address' => $company->getFullAddress(),
    'county' => $company->getAddress()->getCounty(),
    'city' => $company->getAddress()->getCity(),
    'date_added' => date('d-m-Y')
];
foreach ($companyData as $key => $value) {
    if ($key != 'phone') {
        if (($value == "") || ($value == null)) {
            $reqSuccess = 2;
        }
    }
}
if ($reqSuccess == 1) {
    if (!findBy('companies', 'registration_code', $companyData['registration_code'])) {
        $checkInsert = insert('companies', $companyData);
        $companyId=getLastInsert('companies')[0]['id'];
        $initialData = [
            'description' => 'suma initiala',
            'value' => 1000000,
            'day' => date('j', strtotime($currentDate)),
            'month' => date('n', strtotime($currentDate)),
            'year' => date('Y', strtotime($currentDate)),
            'type' => 0,
            'company_id' => $companyId
        ];
        insert('paymentsAndRevenue', $initialData);
        if (!$checkInsert) {
            $reqSuccess = 2;
        }
    } else {
        $reqSuccess = 3;
    }
}
echo $reqSuccess;