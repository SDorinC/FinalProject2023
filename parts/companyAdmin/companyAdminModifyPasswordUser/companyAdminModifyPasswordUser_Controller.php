<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$userObj = null;
$usersIdArray = [];
$usersInfoArray = [];

if (count($_POST) == 2) {
    $usersArray[] = findBy('users', 'id', $_POST['userId']);
    $password = decrypt($usersArray[0][0]['password']);
    echo $password;
} elseif (count($_POST) == 3) {
    $usersArray[] = findBy('users', 'id', $_POST['userId']);
    $newPassword = encrypt($_POST['newPassword']);
    $data = ['password' => $newPassword];
    if (!findByTwoValues('users', 'username', $usersArray[0][0]['username'], 'password', $data['password'])) {
        update('users', $_POST['userId'], $data);
        echo 1;
    } else {
        echo 2;
    }
} else {
    $usersIdArray[] = findByTwoValues('users', 'company_id', $_SESSION['company_id'], 'access_level', 3);
    $usersIdArray = $usersIdArray[0];

    foreach ($usersIdArray as $value) {
        $userObj = new User($value['id']);
        $resultsArray = [$userObj->getId(), $userObj->getUsername()];
        $usersInfoArray[] = $resultsArray;
    }
    echo json_encode($usersInfoArray);
}