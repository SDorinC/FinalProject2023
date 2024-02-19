<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$reqSuccess = 1;
$employeeObj = null;
$employeesIdArray = [];
$employeesInfoArray = [];

if (count($_POST) == 2) {
    $employeesArray[] = findBy('employees', 'id', $_POST['employeeId']);
    echo json_encode($employeesArray);
} elseif (count($_POST) == 7) {
    $userData = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'personal_id_number' => $_POST['personal_id_number'],
        'gross_salary' => $_POST['gross_salary'],
        'employment_date' => $_POST['employment_date']
    ];
    update('employees', $_POST['employeeId'], $userData);
    echo $reqSuccess;
} else {
    $employeesIdArray[] = findBy('employees', 'company_id', $_SESSION['company_id']);
    $employeesIdArray = $employeesIdArray[0];

    foreach ($employeesIdArray as $value) {
        $employeeObj = new Employee($value['id']);
        $resultsArray = [$employeeObj->getId(), $employeeObj->getFirstName(), $employeeObj->getLastName()];
        $employeesInfoArray[] = $resultsArray;
    }
    echo json_encode($employeesInfoArray);
}