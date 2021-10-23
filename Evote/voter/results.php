<?php

// core configuration
include_once "../config/core.php";

// check if logged in as admin
include "../voter/login_checker.php";
include '../config/Database.php';
include '../objects/User.php';
include '../model/Event.php';

include '../service/EventService.php';
include '../service/VoteService.php';

include '../repository/EventRepository.php';
include '../repository/VoteRepository.php';
include '../utils/DataUtils.php';
include "../voter/layout_head.php";

$page_title = "results";

if (isset($_GET['id_event'])) {

    $idEvent = $_GET['id_event'];
    $idVoter = $_GET['id_user'];
    $_SESSION['id_event'] = $idEvent;
    $_SESSION['id_user'] = $idVoter;

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

        <a id="create-back-button" href="../voter/index.php" class="btn btn-primary active" role="button">Back</a>
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
    <table id="custom-color-table" class="text-align-center table table-hover">
        <thead>
        <tr>
            <th scope="col">Candidate Name</th>
            <th scope="col">Votes</th>
        </tr>
        </thead>

        <?php foreach ($lstResults as $result){ ?>

        <tbody>
        <tr>
            <td><?php echo $result["name_candidate"]; ?></td>
            <td><?php echo $result["total"]; ?></td>
        </tr>

        <?php } ?>

        </tbody>
    </table>

    <a id="create-back-button" href="../voter/index.php" class="btn btn-primary active" role="button">Back</a>
    <br><br>

    <form name='public-vote' method='post'>
        <button id="create-voter-button" type="submit" name="public-vote" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span>See public voters
        </button>
    </form>
    </div>
<br>

<?php

if(isset($_POST['public-vote'])) {
    onFunc();
}

function onFunc(){

    $voteService = new VoteService();

    $idVoter = $_SESSION['id_user'];
    $idEvent = $_SESSION['id_event'];

    if (!$voteService->isPublic($idVoter, $idEvent)) { ?>

        <br>
        <div class='container text-justify alert alert-danger'>
            <strong>Only public voters can view.</strong>
        </div>


    <?php } else {

    // get all public voters by event
    $lstPublicVotes = $voteService->getPublicVotes($idEvent);

    ?>
        <div class="container text-justify">
        <table id="custom-color-table" class="text-align-center table table-hover">
            <thead>
            <tr>
                <th scope="col">Candidate</th>
                <th scope="col">Voters</th>
            </tr>
            </thead>

            <?php foreach ($lstPublicVotes as $result){ ?>

            <tbody>
            <tr>
                <td><?php echo $result["name_candidate"]; ?></td>
                <td><?php echo $result["name_user"]; ?></td>
            </tr>

            <?php } ?>

            </tbody>
        </table>
            </div>

        <?php
    }
}


include "../layout_foot.php";

