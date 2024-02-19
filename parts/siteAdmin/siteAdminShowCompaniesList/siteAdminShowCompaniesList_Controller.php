<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$companyObj = null;
$companiesIdArray = [];
$companiesInfoArray = [];

foreach (findAll('companies') as $value) {
    $companiesIdArray[] = $value['id'];
}
foreach ($companiesIdArray as $value) {
    $companyObj = new Company($value);
    $resultsArray = [$companyObj->getName(), $companyObj->getRegistrationCode(), $companyObj->getDateAdded()];
    $companiesInfoArray[] = $resultsArray;
}
echo json_encode($companiesInfoArray);