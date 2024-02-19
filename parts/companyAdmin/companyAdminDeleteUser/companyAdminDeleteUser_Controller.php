<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$userObj = null;
$usersIdArray = [];
$usersInfoArray = [];

if (count($_POST) == 2) {
    delete('users', $_POST['userId']);
}

$usersIdArray[] = findByTwoValues('users', 'company_id', $_SESSION['company_id'], 'access_level', 3);
$usersIdArray = $usersIdArray[0];

foreach ($usersIdArray as $value) {
    $userObj = new User($value['id']);
    $resultsArray = [$userObj->getId(), $userObj->getUsername()];
    $usersInfoArray[] = $resultsArray;
}
echo json_encode($usersInfoArray);