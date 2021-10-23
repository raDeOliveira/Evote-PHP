<?php

include "../config/Database.php";

$db = new Database();
$res = $db->getConnection();

$output = '';
if(isset($_POST["query"])) {
    $search = $_POST["query"];

    $query = "SELECT * FROM event WHERE type_document LIKE '%" . $search . "%' ORDER by id_event ";

    $stmt = $res->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        $output .= '
    <h4 class="text-align-center">Type of document</h4>
    <hr style="border: solid">
    <table id="custom-color-table" class="text-align-center table table-hover">
    <thead>
    <tr>
    <th>Type of document</th>
    <th>Event name</th>
    </thead>
    </tr>';

        // fetch results on DB
        while ($row = $stmt->fetch()) {

            $output .= '
   <tr>
    <td>' . $row["type_document"] . '</td>
    <td>' . $row["event_name"] . '</td>
   </tr>';

        }
        // print results
        echo $output;
    } else {
        echo "<div class='alert alert-danger'>
        <strong>No search found.</strong>
    </div>";
    }

} else {

    // if no search was typed show all events
    $query2 = "SELECT * FROM event";

    $stmt = $res->prepare($query2);
    $stmt->execute();

    if ($stmt->rowCount() > 0) { ?>

        <h4 class="text-align-center">Type of document</h4>
        <hr style="border: solid">
        <table id="custom-color-table" class="text-align-center table table-hover">
            <thead>
            <tr>
                <th>Type of document</th>
                <th>Event name</th>
            </tr>
            </thead>

            <?php

            // fetch all events on DB and print them on HTML table
            while ($row = $stmt->fetch()) { ?>

                <tr>
                    <td> <?php echo $row["type_document"]?> </td>
                    <td> <?php echo $row["event_name"]?> </td>
                </tr>
            <?php } ?>
        </table>
    <?php }
} ?>
