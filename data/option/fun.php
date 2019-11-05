<?php
// Function Sum Cloum Database
function sumallcol($table, $database) {
    global $con;
    $select = $con->prepare("SELECT $table FROM $database $where");
    $select->execute();
    $count= $select->rowCount();
    return $count;
}

// Function Sum Numbers Cloum
function sumplausnum($col,$nameas, $base,$where) {
    global $con;
    $root = $con->prepare("SELECT SUM($col) AS $nameas FROM $base $where");
    $root->execute();
    $row= $root->fetch();
    return $row;
}

// Function Search Like
function search($tables,$namebase, $where, $search, $orders) {
    global $con;
    $searchlike = $con->prepare("SELECT $tables FROM $namebase WHERE $where LIKE $search $orders");
    $searchlike->execute();
    return $searchlike;
}

