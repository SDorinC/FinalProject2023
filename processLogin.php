<?php
include 'functionsAndClassesLoader.php';

$username = $_POST['username'];
$password = encrypt($_POST['password']);

$userData = query("SELECT * FROM users WHERE username='$username' AND password='$password'");

if (count($userData) > 0) {
    $_SESSION['user_id'] = $userData[0]['id'];
    $_SESSION['company_id'] = $userData[0]['company_id'];
    if ($userData[0]['access_level'] == 1) {
        header('Location: homePageSiteAdmin.php');
    } elseif ($userData[0]['access_level'] == 2) {
        header('Location: homePageCompanyAdmin.php');
    } elseif ($userData[0]['access_level'] == 3) {
        header('Location: homePageCompanyUser.php');
    } else {
        $_SESSION['loginFailed'] = true;
        header('Location: index.php');
    }
} else {
    $_SESSION['loginFailed'] = true;
    header('Location: index.php');
}