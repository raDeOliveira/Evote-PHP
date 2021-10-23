<?php

include "../config/Database.php";

$db = new Database();
$res = $db->getConnection();

$output = '';
if(isset($_POST["query"])) {
    $search = $_POST["query"];

    $query = "SELECT * FROM event WHERE event_name LIKE '%" . $search . "%' ORDER by id_event ";

    $stmt = $res->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        $output .= '
    <h4 class="text-align-center">Events</h4>
    <hr style="border: solid">
    <table id="custom-color-table" class="text-align-center table table-hover">
    <thead>
    <tr>
    <th>Event name</th>
    <th>Start date</th>
    <th>End date</th>
    <th>Event description</th>
    <th>Type document</th>
    <th>Event results</th>
    <th>Edit event</th>
    </thead>
    </tr>';

        // fetch results on DB
        while ($row = $stmt->fetch()) {

            $output .= '
   <tr>
    <td>' . $row["event_name"] . '</td>
    <td>' . $row["start_date"] . '</td>
    <td>' . $row["end_date"] . '</td>
    <td>' . $row["event_description"] . '</td>
    <td>' . $row["type_document"] . '</td>
    
    <td><a href="../views/results.php?id_event=' . $row['id_event'] . '">Results</a></td>
    <td><a href="../views/edit-event.php?id_event=' . $row['id_event'] . '">Edit</a></td>
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

        <h4 class="text-align-center">Events</h4>
        <hr style="border: solid">
        <table id="custom-color-table" class="text-align-center table table-hover">
            <thead>
            <tr>
                <th>Event name</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Event description</th>
                <th>Type document</th>
                <th>Event results</th>
                <th>Edit event</th>
            </tr>
            </thead>

            <?php

            // fetch all events on DB and print them on HTML table
            while ($row = $stmt->fetch()) { ?>

                <tr>
                    <td> <?php echo $row["event_name"]?> </td>
                    <td> <?php echo $row["start_date"]?> </td>
                    <td> <?php echo $row["end_date"]?> </td>
                    <td> <?php echo $row["event_description"]?> </td>
                    <td> <?php echo $row["type_document"]?> </td>

                    <!-- editing -->
                    <td><a href='../views/results.php?id_event=<?php echo $row["id_event"]?>'>Results</a></td>
                    <td><a href='../views/edit-event.php?id_event=<?php echo $row["id_event"]?>'>Edit</a></td>
                </tr>
            <?php } ?>
        </table>
    <?php }
} ?>
