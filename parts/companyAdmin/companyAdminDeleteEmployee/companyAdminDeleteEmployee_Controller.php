<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$employeeObj = null;
$employeesIdArray = [];
$employeesInfoArray = [];

if (count($_POST) == 2) {
    delete('employees', $_POST['employeeId']);
}

$employeesIdArray[] = findBy('employees', 'company_id', $_SESSION['company_id']);
$employeesIdArray = $employeesIdArray[0];

foreach ($employeesIdArray as $value) {
    $employeeObj = new Employee($value['id']);
    $resultsArray = [$employeeObj->getId(), $employeeObj->getFirstName(), $employeeObj->getLastName()];
    $employeesInfoArray[] = $resultsArray;
}
echo json_encode($employeesInfoArray);