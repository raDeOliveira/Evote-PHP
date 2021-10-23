<?php

include "../config/Database.php";

$db = new Database();
$res = $db->getConnection();

$output = '';
if(isset($_POST["query"])) {
    $search = $_POST["query"];

    $query = "SELECT * FROM user WHERE name_user LIKE '%" . $search . "%' 
    OR email_user LIKE '%" . $search . "%' ORDER by id_user ";

    $stmt = $res->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        $output .= '
    <h4 class="text-align-center">Voters</h4>
    <hr style="border: solid">
    <table id="custom-color-table" class="text-align-center table table-hover">
    <thead>
    <tr>
        <th>Voter name</th>
        <th>Email</th>
        <th>Identification Nº</th>
        <th>Type of document</th>
        <th>Edit voter</th>
    </thead>
    </tr>';

        // fetch results on DB
        while ($row = $stmt->fetch()) {

            $output .= '
    <tr>
        <td>' . $row["name_user"] . '</td>
        <td>' . $row["email_user"] . '</td>
        <td>' . $row["type_document"] . '</td>
        <td>' . $row["nidentificacao_user"] . '</td>

        <td><a href="../views/edit-voter.php?id_user=' . $row['id_user'] . '">Edit</a></td>
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
    $query2 = "SELECT * FROM user";

    $stmt = $res->prepare($query2);
    $stmt->execute();

    if ($stmt->rowCount() > 0) { ?>

        <h4 class="text-align-center">Voters</h4>
        <hr style="border: solid">
        <table id="custom-color-table" class="text-align-center table table-hover">
            <thead>
            <tr>
                <th>Voter name</th>
                <th>Email</th>
                <th>Identification Nº</th>
                <th>Type of document</th>
                <th>Edit voter</th>
            </tr>
            </thead>

            <?php

            // fetch all events on DB and print them on HTML table
            while ($row = $stmt->fetch()) { ?>

                <tr>
                    <td> <?php echo $row["name_user"]?> </td>
                    <td> <?php echo $row["email_user"]?> </td>
                    <td> <?php echo $row["type_document"]?> </td>
                    <td> <?php echo $row["nidentificacao_user"]?> </td>

                    <!-- editing -->
                    <td><a href='../views/edit-voter.php?id_user=<?php echo $row["id_user"]?>'>Edit</a></td>
                </tr>
            <?php } ?>
        </table>
    <?php }
}
?>