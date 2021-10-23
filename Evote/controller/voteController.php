<?php

// core configuration
include_once "../config/core.php";
include_once '../model/Event.php';
include_once "../service/CandidateService.php";
include_once '../objects/User.php';
include_once '../model/Voters.php';

include_once '../model/Vote.php';
include_once "../config/Database.php";
include_once "../model/Candidate.php";
include_once "../utils/Utils.php";

include_once "../voter/layout_head.php";
include_once "../service/VoteService.php";
include_once "../service/VoterService.php";
include_once "../service/EventService.php";
include_once "../repository/VoterRepository.php";
include_once "../repository/VoteRepository.php";
include_once "../repository/EventRepository.php";
include '../utils/DataUtils.php';

include_once "../voter/login_checker.php";

$page_title = "voteController";

$event = new Event();
$hasVoted = null;
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
    if (!$dataUtils->verifyEndDateEvent($voteEndDate)) {

        echo "<br><br><br><br>";
        echo "<div class='alert alert-danger'>
        <strong>The event has closed! No more votes are accepted!</strong>
    </div>";
        ?>

        <a id="create-back-button" href="../voter/index.php" class="btn btn-primary active" role="button">Back</a>

        <?php
        include '../voter/layout_foot.php';
        die();
    }

    $voteService = new VoteService();
    $hasVoted  = $voteService->hasVoted($idVoter, $idEvent);
}

// check if voter has already voted
if ($hasVoted) {
    echo "<br><br><br><br>";
    echo "<div class='alert alert-danger'>
            <strong>You have already voted</strong>
            </div>";
    ?>

    <a id="create-back-button" href="../voter/index.php" class="btn btn-primary active" role="button">Back</a>

    <?php
    include '../voter/layout_foot.php';
    die();

}

if (isset($_POST['vote'])) {

    $candidate = $_POST['your-vote'];
    $idEvent = $_SESSION['id_event'];
    $idVoter = $_SESSION['id_user'];
    $publicvote = $_POST['public-vote'];

    // new vote object
    $vote = new Vote();
    $vote->setIdCandidate($candidate);
    $vote->setIdEvent($idEvent);
    $vote->setIdVoter($idVoter);
    $vote->setPublicVote($publicvote);

    $voteService = new VoteService();
    $voteService->saveVote($vote);

    // send confirmation email for the voter
    $voteService = new VoterService();
    $voteService->sendVoteConfirmationEmail($idVoter, $idEvent);

    echo "<br><br><br><br>";
    echo "<div class='alert alert-success'>
            <strong>Vote registered</strong>
            </div>";
    ?>

    <a id="create-back-button" href="../voter/index.php" class="btn btn-primary active" role="button">Back</a>

    <?php
    include '../voter/layout_foot.php';
    die();

}

// get all candidates by id
$candidateService = new CandidateService();
$lstCandidates = $candidateService->getAllCandidatesByIdEvent($idEvent);

// system date
$date = date("Y-m-d");
$_SESSION['d'] = $date;

$eventService = new EventService();
$event = $eventService->getEventById($idEvent);
$eventName = $event->getNameEvent();

?>

    <br><br><br><br>
    <h4 style="text-align: center"><?php echo $eventName; ?> Election | <?php echo $date; ?></h4>
    <hr style="border: solid">

    <form method="post" action="voteController.php">
        <table id="custom-color-table" class="text-align-center table table-hover">
            <thead>
            <tr>
                <th scope="col">First</th>
                <th scope="col">Vote</th>
            </tr>
            </thead>

            <?php foreach ($lstCandidates as $candidate) { ?>

            <tbody>
            <tr>
                <td><?php echo $candidate->getNameCandidate() ?></td>
                <td><input type='radio' name='your-vote' value='<?php echo $candidate->getIdCandidate() ?> '/></td>
            </tr>

            <?php } ?>

            </tbody>
        </table>

        <h5>Public vote
            <label for='public-vote'></label><input type='radio' id='public-vote' name='public-vote' checked value='Yes'>Yes
            <label for='public-vote-input'></label><input type='radio' id='public-vote-input' name='public-vote' value='No'>No
        </h5>

        <br>
        <div>
            <button id="create-back-button" type="submit" name="vote" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus"></span> Vote
            </button>
            <a id="create-back-button" href="../voter/index.php" class="btn btn-primary active" role="button">Back</a>
        </div>
    </form>

    <?php
    include '../voter/layout_foot.php';
    ?>
