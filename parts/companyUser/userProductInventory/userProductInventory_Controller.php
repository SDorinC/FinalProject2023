<?php
ob_start();
include '../../header.php';
ob_end_clean();

giveAccess();

$productObj = null;
$productsIdArray = [];
$productsInfoArray = [];

foreach (findBy('products', 'company_id', $_SESSION['company_id']) as $value) {
    $productsIdArray[] = $value['id'];
}
foreach ($productsIdArray as $value) {
    $productObj = new Product($value);

    if ($productObj->getQuantity() > 0) {
        $resultsArray = [$productObj->getName(), $productObj->getPrice() . ' lei',
            $productObj->getVat() . '%', $productObj->getQuantity()];
        $productsInfoArray[] = $resultsArray;
    }
}
echo json_encode($productsInfoArray);