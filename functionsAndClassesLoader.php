<?php
session_start();

include 'classes/User.php';
include 'classes/Company.php';
include 'classes/Employee.php';
include 'classes/Product.php';
include 'classes/Transaction.php';
include 'classes/FinancialTransaction.php';

$salt = "sdds4322dsdz";
$connection = mysqli_connect('45.15.23.59', 'root', 'Sco@l@it123', 'national-04-dorin');

function query($sql) {
    global $connection;
    $query = mysqli_query($connection, $sql);
    if (is_bool($query)) {
        return $query;
    } else {
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

}

function insert($tableName, $data) {
    $columns = [];
    $values = [];
    foreach ($data as $key => $value) {
        $columns[] = $key;
        $values[] = $value;
    }
    $columnsStr = implode('`,`', $columns);
    $valuesStr = implode("','", $values);

    $sql = "INSERT INTO $tableName (`$columnsStr`) VALUES ('$valuesStr');";
    return query($sql);
}

function getLastInsert($tableName) {
    $sql = "SELECT * FROM $tableName WHERE id = LAST_INSERT_ID()";
    return query($sql);
}

function update($tableName, $id, $data) {
    foreach ($data as $key => $value) {
        $sql = "UPDATE $tableName SET $key='$value' WHERE id='$id';";
        query($sql);
    }
}

function delete($tableName, $id) {
    $sql = "DELETE FROM  $tableName WHERE id='$id';";
    return query($sql);
}

function find($tableName, $id) {
    $sql = "SELECT * FROM $tableName WHERE id= '$id' LIMIT 1;";
    return query($sql)[0];
}

function findAll($tableName) {
    $sql = "SELECT * FROM $tableName;";
    return query($sql);
}

function findBy($tableName, $column, $columnValue) {
    $sql = "SELECT * FROM $tableName WHERE $column= '$columnValue';";
    return query($sql);
}

function findByTwoValues($tableName, $column1, $columnValue1, $column2, $columnValue2) {
    $sql = "SELECT * FROM $tableName WHERE $column1= '$columnValue1' AND $column2='$columnValue2';";
    return query($sql);
}

function findByThreeValues($tableName, $column1, $columnValue1, $column2, $columnValue2, $column3, $columnValue3) {
    $sql = "SELECT * FROM $tableName WHERE $column1= '$columnValue1' AND $column2='$columnValue2'AND $column3='$columnValue3';";
    return query($sql);
}

function encrypt($text): string {
    global $salt;
    $passwordArray = str_split($text);
    $encryptedPassword = "";
    for ($i = 0; $i < count($passwordArray); $i++) {
        if ($i % 2 == 0) {
            $encryptedPassword = $encryptedPassword . mb_ord($passwordArray[$i]) . $salt . $i * ($i + 1) . "qwe";
        } else {
            $encryptedPassword = $encryptedPassword . mb_ord($passwordArray[$i]) . $i * ($i + 2) . $salt . "zxc";
        }
    }
    return $encryptedPassword;
}

function decrypt($text): string {
    global $salt;
    $decryptedPassword = "";
    $unicodeValuesTempArr = [];
    $unicodeValuesArr = [];
    $keyArr = ["qwe", "zxc"];
    $decryptedPasswordTemp = str_replace($keyArr, "|", $text);
    $decryptedPasswordArrTemp = explode("|", $decryptedPasswordTemp);
    array_pop($decryptedPasswordArrTemp);
    for ($i = 0; $i < count($decryptedPasswordArrTemp); $i++) {
        if ($i % 2 == 0) {
            $unicodeValuesTempArr[] = explode($salt . $i * ($i + 1), $decryptedPasswordArrTemp[$i]);
        } else {
            $unicodeValuesTempArr[] = explode($i * ($i + 2) . $salt, $decryptedPasswordArrTemp[$i]);
        }
    }
    foreach ($unicodeValuesTempArr as $value) {
        $unicodeValuesArr[] = $value[0];
    }
    foreach ($unicodeValuesArr as $value) {
        $decryptedPassword = $decryptedPassword . mb_chr($value);
    }
    return $decryptedPassword;
}

function giveAccess() {
    $verifyAccess = array_keys($_POST)[0];
    $verifyAccess = explode('/', $verifyAccess)[3];
    $verifyAccess = explode('_', $verifyAccess)[0];
    $filename = $_SERVER['PHP_SELF'];
    $filename = explode('/', $filename)[6];
    $filename = explode('.', $filename)[0];
    if ($verifyAccess != $filename) {
        session_destroy();
        header('Location: ../../../index.php');
        die();
    }
}