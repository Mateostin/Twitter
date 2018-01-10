<?php

require_once('../../src/connection.php');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Nie można połaczyć z baza danych!");
mysqli_set_charset($connection, 'utf8');
$result = mysqli_select_db($connection, DB_DBNAME) or die("Can't select database. Please check DB name and try again");

if (isset($_REQUEST['query'])) {
    $query = $_REQUEST['query'];
    $sql = mysqli_query($connection, "SELECT firstname, secondname,  id, avatar FROM Users WHERE firstname LIKE '%{$query}%' OR secondname LIKE '%{$query}%'");
    $array = array();
    while ($row = mysqli_fetch_array($sql)) {
        $array[] = array(
            'label' => $row['firstname'],
            'value' => "<a href='index.php?user=" . $row['id'] . "'><img src=$row[avatar] height='35' width='35'> $row[firstname] $row[secondname]</a>",
        );
    }

    echo json_encode($array);
}

?>