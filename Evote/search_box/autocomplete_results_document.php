<?php

include "../config/Database.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

if (isset($_GET['term'])) {
    $search = $_GET['term'];

    $query = "SELECT * FROM event WHERE type_document LIKE '%" . $search . "%' ORDER by id_event ";

    $stmt = $db->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            $lstResults [] = $row['type_document'];
        }
    } else {
        $lstResults = array();
    }
    //return json res
    echo json_encode($lstResults);

}