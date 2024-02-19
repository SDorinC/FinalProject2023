<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

if (count($_POST) == 6) {
    $data = [
        'partner_name' => $_POST['partnerName'],
        'partner_registration_code' => $_POST['partnerCUI'],
        'transaction_number' => $_POST['transactionNr'],
        'transaction_date' => $_POST['transactionDate'],
        'company_id' => $_SESSION['company_id'],
        'transaction_type' => 2,
        'total' => $_POST['transactionTotal']
    ];
    insert('transactions', $data);
    $transaction = getLastInsert('transactions');
    echo $transaction[0]['id'];
} elseif (count($_POST) == 1) {
    $productsArr = findBy('products', 'company_id', $_SESSION['company_id']);
    echo json_encode($productsArr);
} elseif (count($_POST) == 3) {
    $productsInfo = null;
    foreach ($_POST['products'] as $value) {
        $productData = [
            'id' => $value[0],
            'price' => $value[1],
            'quantity' => $value[2]
        ];
        $productsInfo .= $productData['id'] . '-' . $productData['price'] . '-' . $productData['quantity'] . '|';

        $productObj = new Product($productData['id']);
        $productQuantity = $productObj->getQuantity() - $productData['quantity'];
        $updateProductData = [
            'quantity' => $productQuantity
        ];
        update('products', $productObj->getId(), $updateProductData);
    }
    $transactionData = [
        'transaction_products' => $productsInfo
    ];
    update('transactions', $_POST['transactionId'], $transactionData);
}