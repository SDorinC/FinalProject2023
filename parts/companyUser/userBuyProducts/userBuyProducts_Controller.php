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
        'transaction_type' => 1,
        'total' => $_POST['transactionTotal']
    ];
    insert('transactions', $data);
    $transaction = getLastInsert('transactions');
    echo $transaction[0]['id'];
} else {
    $productsInfo = null;
    foreach ($_POST['products'] as $value) {
        $productData = [
            'name' => $value[0],
            'price' => $value[1],
            'vat' => $value[2],
            'quantity' => $value[3],
            'company_id' => $_SESSION['company_id']
        ];
        if (findByThreeValues('products', 'name', $productData['name'], 'price', $productData['price'], 'company_id', $_SESSION['company_id'])) {
            $product = findByThreeValues('products', 'name', $productData['name'], 'price', $productData['price'], 'company_id', $_SESSION['company_id']);
            $productQuantity = $product[0]['quantity'] + $productData['quantity'];
            $productsInfo .= $product[0]['id'] . '-' . $productData['quantity'] . '|';
            $updateProductData = [
                'quantity' => $productQuantity
            ];
            update('products', $product[0]['id'], $updateProductData);
        } else {
            insert('products', $productData);
            $productId = getLastInsert('products')[0]['id'];
            $productsInfo .= $productId . '-' . $productData['quantity'] . '|';
        }
    }
    $transactionData = [
        'transaction_products' => $productsInfo
    ];
    update('transactions', $_POST['transactionId'], $transactionData);
}