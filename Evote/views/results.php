<?php

// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "../admin/login_checker.php";
include '../config/Database.php';
include '../objects/User.php';
include '../model/Event.php';

include '../service/EventService.php';
include '../service/VoteService.php';

include '../repository/EventRepository.php';
include '../utils/DataUtils.php';
include "../admin/layout_head.php";

$page_title = "results";

if (isset($_GET['id_event'])) {

    $idEvent = $_GET['id_event'];

    $eventService = new EventService();
    $event = $eventService->getEventById($idEvent);

    // event validation
    $dataUtils = new DataUtils();
    $voteEndDate = $event->getEndDate();

    // check if the data of event has finished or not open for vote
    if ($dataUtils->verifyEndDateEvent($voteEndDate)) {

        echo "<br><br><br><br>";
        echo "<div class='alert alert-danger'>
        <strong>The event hasn't been closed!</strong>
    </div>";
        ?>
        <a id="create-back-button" href="../admin/read_events.php" class="btn btn-primary active" role="button">Back</a>
        </div>
        <?php
        exit();
    }

    // get candidates for the desired event and count votes
    $voteService = new VoteService();
    $lstResults = $voteService->countVotes($idEvent);

}
?>

    <br><br><br><br>
    <h4 class='text-align-center'><?php echo $event->getNameEvent() ?> results</h4>
    <hr style='border: solid'>
    <table id="custom-color-table" class='text-align-center table table-responsive table-bordered'>
        <thead class = "w-auto p-3">
        <tr>
            <th class="w-100 p-3">Candidate Name</th>
            <th class="w-100 p-3">Votes</th>
        </tr>

        <?php foreach ($lstResults as $result){ ?>

            <tr>
                <td><?php echo $result["name_candidate"]; ?></td>
                <td><?php echo $result["total"]; ?></td>
            </tr>

        <?php } ?>
        </thead>

    </table>

    <a id="create-back-button" href="../admin/read_events.php" class="btn btn-primary active" role="button">Back</a>
    <br><br>
</div>

<?php

include "../layout_foot.php";
