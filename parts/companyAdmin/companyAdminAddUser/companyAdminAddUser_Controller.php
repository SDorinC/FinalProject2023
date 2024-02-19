<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$reqSuccess = 1;

if (count($_POST) == 3) {
    $userData = [
        'username' => $_POST['username'],
        'password' => encrypt($_POST['password']),
        'access_level' => 3,
        'company_id' => $_SESSION['company_id']
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
}
echo $reqSuccess;