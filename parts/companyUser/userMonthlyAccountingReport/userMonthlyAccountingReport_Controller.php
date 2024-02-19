<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

date_default_timezone_set('Europe/Bucharest');

$financialOperationsObjArr = [];
$filteredArr = [];
$month = $_POST['month'];
$year = $_POST['year'];

$financialOperationsArr = findBy('paymentsAndRevenue', 'company_id', $_SESSION['company_id']);

foreach ($financialOperationsArr as $value) {
    if (($value['month'] == $month) && ($value['year'] == $year)) {
        $filteredArr[] = $value;
    }
}

foreach ($filteredArr as $value) {
    $financialOperationsObj = new FinancialTransaction($value['id']);
    $infoArr = [$financialOperationsObj->getDescription(), $financialOperationsObj->getValue(), $financialOperationsObj->getDay(),
        $financialOperationsObj->getMonth(), $financialOperationsObj->getYear(), $financialOperationsObj->getType()];
    $financialOperationsObjArr[] = $infoArr;
}

echo json_encode($financialOperationsObjArr);