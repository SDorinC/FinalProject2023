<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$companyObj = null;
$companiesIdArray = [];
$companiesInfoArray = [];

if (count($_POST) == 2) {
    $usersArray[] = findByTwoValues('users', 'company_id', $_POST['rowId'],'access_level', 2);
    echo json_encode($usersArray);
} elseif (count($_POST) == 3) {
    delete('users', $_POST['userRowId']);
    $usersArray[] = findBy('users', 'company_id', $_POST['rowId']);
    echo json_encode($usersArray);
} else {
    foreach (findAll('companies') as $value) {
        $companiesIdArray[] = $value['id'];
    }
    foreach ($companiesIdArray as $value) {
        $companyObj = new Company($value);
        $resultsArray = [$companyObj->getId(), $companyObj->getName()];
        $companiesInfoArray[] = $resultsArray;
    }
    echo json_encode($companiesInfoArray);
}