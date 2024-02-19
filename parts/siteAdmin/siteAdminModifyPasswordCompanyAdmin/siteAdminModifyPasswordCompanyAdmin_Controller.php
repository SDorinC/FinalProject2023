<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$companyObj = null;
$companiesIdArray = [];
$companiesInfoArray = [];


if (count($_POST) == 2) {
    $usersArray[] = findByTwoValues('users', 'company_id', $_POST['rowId'], 'access_level', 2);
    echo json_encode($usersArray);
} elseif (count($_POST) == 3) {
    $usersArray[] = findBy('users', 'id', $_POST['userRowId']);
    $password = decrypt($usersArray[0][0]['password']);
    echo $password;
} elseif (count($_POST) == 4) {
    $usersArray[] = findBy('users', 'id', $_POST['userRowId']);
    $newPassword = encrypt($_POST['newPassword']);
    $data = ['password' => $newPassword];
    if (!findByTwoValues('users', 'username', $usersArray[0][0]['username'], 'password', $data['password'])) {
        update('users', $_POST['userRowId'], $data);
        echo 1;
    } else {
        echo 2;
    }
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