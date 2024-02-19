<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$reqSuccess = 1;

if (count($_POST) == 6) {
    $userData = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'personal_id_number' => $_POST['personal_id_number'],
        'gross_salary' => $_POST['gross_salary'],
        'employment_date' => $_POST['employment_date'],
        'company_id' => $_SESSION['company_id']
    ];
    if (!findByTwoValues('employees', 'personal_id_number', $userData['personal_id_number'], 'company_id', $userData['company_id'])) {
        insert('employees', $userData);

    } else {
        $reqSuccess = 2;
    }
}
echo $reqSuccess;