<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

date_default_timezone_set('Europe/Bucharest');

function getTransactions($transactionType) {
    $transactionsArr = [];
    $transactionDataArr = findByThreeValues('transactions', 'company_id', $_SESSION['company_id'], 'transaction_type',
        $transactionType, 'paid', 0);
    $transactionIdArr = [];
    foreach ($transactionDataArr as $value) {
        $transactionIdArr[] = $value['id'];
    }
    foreach ($transactionIdArr as $value) {
        $transaction = new Transaction($value);
        $arr = [$transaction->getId(), $transaction->getPartnerName(), $transaction->getPartnerRegistrationCode(), $transaction->getTransactionNumber(),
            $transaction->getTransactionDate(), $transaction->getTotal()];
        $transactionsArr[] = $arr;
    }

    echo json_encode($transactionsArr);

    if (count($_POST) == 3) {
        $currentDate = date('Y-m-d');
        $data = [
            'paid' => '1'
        ];
        update('transactions', $_POST['transactionId'], $data);
        $transactionInfo = new Transaction($_POST['transactionId']);
        $description = '';
        if ($transactionType == 2) {
            $description = 'Incasare de la ' . $transactionInfo->getPartnerName() . ', CUI/CIF ' . $transactionInfo->getPartnerRegistrationCode() .
                ' factura cu numarul ' . $transactionInfo->getTransactionNumber() . ' din data de ' . $transactionInfo->getTransactionDate();
        } elseif ($transactionType == 1) {
            $description = 'Plata la ' . $transactionInfo->getPartnerName() . ', CUI/CIF ' . $transactionInfo->getPartnerRegistrationCode() .
                ' factura cu numarul ' . $transactionInfo->getTransactionNumber() . ' din data de ' . $transactionInfo->getTransactionDate();
        }
        $financialOperationData = [
            'description' => $description,
            'value' => $transactionInfo->getTotal(),
            'day' => date('j', strtotime($currentDate)),
            'month' => date('n', strtotime($currentDate)),
            'year' => date('Y', strtotime($currentDate)),
            'type' => $transactionType,
            'company_id' => $_SESSION['company_id']
        ];
        insert('paymentsAndRevenue', $financialOperationData);
    }
}

if ($_POST['requestId'] == 1) {
    getTransactions(2);
} elseif ($_POST['requestId'] == 2) {
    getTransactions(1);
} elseif ($_POST['requestId'] == 3) {
    $employeesArr = [];
    $employeeDataArr = findByTwoValues('employees', 'company_id', $_SESSION['company_id'],
        'paid', 0);
    $employeeIdArr = [];
    foreach ($employeeDataArr as $value) {
        $employeeIdArr[] = $value['id'];
    }
    foreach ($employeeIdArr as $value) {
        $employee = new Employee($value);
        $arr = [$employee->getId(), $employee->getFirstName() . ' ' . $employee->getLastName(), $employee->getPersonalIdNumber(),
            $employee->getGrossSalary()];
        $employeesArr[] = $arr;
    }

    echo json_encode($employeesArr);

    if (count($_POST) == 3) {
        $currentDate = date('Y-m-d');
        $data = [
            'paid' => '1'
        ];
        update('employees', $_POST['transactionId'], $data);
        $employeeInfo = new Employee($_POST['transactionId']);
        $description = 'Plata salariu pentru ' . $employeeInfo->getFirstName() . ' ' . $employeeInfo->getLastName() .
            ' cu CNP ' . $employeeInfo->getPersonalIdNumber();
        $financialOperationData = [
            'description' => $description,
            'value' => $employeeInfo->getGrossSalary(),
            'day' => date('j', strtotime($currentDate)),
            'month' => date('n', strtotime($currentDate)),
            'year' => date('Y', strtotime($currentDate)),
            'type' => 3,
            'company_id' => $_SESSION['company_id']
        ];
        insert('paymentsAndRevenue', $financialOperationData);
    }
} elseif ($_POST['requestId'] == 4) {
    $currentDate = date('Y-m-d');
    $data = [
        'description' => $_POST['description'],
        'value' => $_POST['value'],
        'day' => date('j', strtotime($currentDate)),
        'month' => date('n', strtotime($currentDate)),
        'year' => date('Y', strtotime($currentDate)),
        'type' => 4,
        'company_id' => $_SESSION['company_id']
    ];
    insert('paymentsAndRevenue', $data);
    echo 'sss';
}