<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$transactionObj = null;
$transactionsIdArray = [];
$transactionsInfoArray = [];
$transactionProducts = [];
$transactionProductsData = [];

if (count($_POST) == 2) {
    $transactionObj = new Transaction($_POST['transactionId']);
    $productsInfoArray = [];

    $productsInfo = $transactionObj->getTransactionProducts();
    $productsInfo = explode('|', $productsInfo);
    array_pop($productsInfo);

    foreach ($productsInfo as $value) {
        $productInfo = explode('-', $value);
        $productsInfoArray[] = $productInfo;
    }

    foreach ($productsInfoArray as $value) {
        $product = new Product($value[0]);
        if (count($value) == 2) {
            $product->setQuantity($value[1]);
        } elseif (count($value) == 3) {
            $product->setQuantity($value[2]);
            $product->setPrice($value[1]);
        }
        $transactionProducts[] = $product;
    }

    foreach ($transactionProducts as $product) {
        $infoArr = [$product->getName(), $product->getPrice(), $product->getVat(), $product->getQuantity()];
        $transactionProductsData[] = $infoArr;
    }


    $resultsArray = [$transactionObj->getPartnerName(), $transactionObj->getPartnerRegistrationCode(), $transactionObj->getTransactionNumber(),
        $transactionObj->getTransactionDate(), $transactionObj->getTransactionType(), $transactionProductsData];

    echo json_encode($resultsArray);
} else {
    foreach (findBy('transactions', 'company_id', $_SESSION['company_id']) as $value) {
        $transactionsIdArray[] = $value['id'];
    }
    foreach ($transactionsIdArray as $value) {
        $transactionObj = new Transaction($value);

        $resultsArray = [$transactionObj->getId(), $transactionObj->getPartnerName(), $transactionObj->getPartnerRegistrationCode()
            , $transactionObj->getTransactionNumber(), $transactionObj->getTransactionDate(), $transactionObj->getTransactionType()];
        $transactionsInfoArray[] = $resultsArray;
    }
    echo json_encode($transactionsInfoArray);
}