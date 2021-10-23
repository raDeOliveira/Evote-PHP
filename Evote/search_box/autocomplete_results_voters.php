<?php

include "../config/Database.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

if (isset($_GET['term'])) {
    $search = $_GET['term'];

    $query = "SELECT * FROM user WHERE name_user LIKE '%" . $search . "%' 
    OR email_user LIKE '%" . $search . "%' ORDER by id_user ";

    $stmt = $db->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            $lstResults [] = $row['name_user'];
            $lstResults [] = $row['email_user'];
        }
    } else {
        $lstResults = array();
    }
    //return json res
    echo json_encode($lstResults);

}