<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$companyObj = null;
$companiesIdArray = [];
$companiesInfoArray = [];

if (count($_POST) == 2) {
    delete('companies', $_POST['rowId']);
}

foreach (findAll('companies') as $value) {
    $companiesIdArray[] = $value['id'];
}
foreach ($companiesIdArray as $value) {
    $companyObj = new Company($value);
    $resultsArray = [$companyObj->getId(), $companyObj->getName()];
    $companiesInfoArray[] = $resultsArray;
}
echo json_encode($companiesInfoArray);