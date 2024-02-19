<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$employeeObj = null;
$employeesIdArray = [];
$employeesInfoArray = [];
if (count($_POST) == 1) {
    foreach (findBy('employees', 'company_id', $_SESSION['company_id']) as $value) {
        $employeesIdArray[] = $value['id'];
    }
    foreach ($employeesIdArray as $value) {
        $employeeObj = new Employee($value);
        $cas = $employeeObj->getGrossSalary() / 100 * 25;
        $cass = $employeeObj->getGrossSalary() / 100 * 10;
        $tax = ($employeeObj->getGrossSalary() - $cas - $cass) / 100 * 10;
        $netSalary = $employeeObj->getGrossSalary() - $cas - $cass - $tax;

        ob_start();
        $casFormatted = number_format($cas, 2);
        $cassFormatted = number_format($cass, 2);
        $taxFormatted = number_format($tax, 2);
        $netSalaryFormatted = number_format($netSalary, 2);
        ob_end_clean();

        $resultsArray = [$employeeObj->getFirstName() . ' ' . $employeeObj->getLastName(), $employeeObj->getPersonalIdNumber(),
            $employeeObj->getGrossSalary() . ' lei', $casFormatted . ' lei', $cassFormatted . ' lei', $taxFormatted . ' lei',
            $netSalaryFormatted . ' lei', $employeeObj->getEmploymentDate()];
        $employeesInfoArray[] = $resultsArray;
    }
    echo json_encode($employeesInfoArray);
} elseif (count($_POST) == 2) {
    $resetSalariesArr = [];
    foreach (findByTwoValues('employees', 'company_id', $_SESSION['company_id'], 'paid', '1') as $value) {
        $resetSalariesArr[] = $value['id'];
    }
    foreach ($resetSalariesArr as $value) {
        $resetEmployeeSalaryObj = new Employee($value);
        $data = [
            'paid' => '0'
        ];
        update('employees', $resetEmployeeSalaryObj->getId(), $data);
    }
}
