<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$reqSuccess = 1;
$companyObj = null;
$companiesIdArray = [];
$companiesInfoArray = [];

if (count($_POST) == 4) {
    $userData = [
        'username' => $_POST['username'],
        'password' => encrypt($_POST['password']),
        'access_level' => 2,
        'company_id' => $_POST['rowId']
    ];
    if (!findByTwoValues('users', 'username', $userData['username'], 'company_id', $userData['company_id'])) {
        if (!findByTwoValues('users', 'username', $userData['username'], 'password', $userData['password'])) {
            insert('users', $userData);
        } else {
            $reqSuccess = 2;
        }
    } else {
        $reqSuccess = 2;
    }
    echo $reqSuccess;
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