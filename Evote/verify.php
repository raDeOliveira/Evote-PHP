<?php

// core configuration
include_once "config/core.php";

// include classes
include_once 'config/Database.php';
include_once 'objects/User.php';

include_once 'utils/DataUtils.php';

include_once 'model/Voters.php';
include_once 'model/Event.php';

include_once 'repository/EventRepository.php';
include_once 'repository/VoterRepository.php';
include_once 'repository/VoteRepository.php';

include_once 'service/VoterService.php';
include_once 'service/EventService.php';
include_once 'service/VoteService.php';
?>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <div class="container text-justify"">
<?php

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

// validation if the link of the user has a valid structure by GET method
if (isset($_GET['access_code']) && isset($_GET['id_event']) && isset($_GET['id_user'])){

    $accessCode = $_GET['access_code'];
    $idEvent = $_GET['id_event'];
    $idUser = $_GET['id_user'];

    // get the voter data
    $voterService = new VoterService();
    $voter = $voterService->getVoterById($idUser);

    // get the event details
    $eventService = new EventService();
    $event = $eventService->getEventById($idEvent);

    // make a session variables
    $_SESSION['make_vote'] = true;
    $_SESSION['id_event'] = $event->getIdEvent();
    $_SESSION['id_user'] = $voter->getIdUser();


    // event validation
    $dataUtils = new DataUtils();

    $voteEndDate = $event->getEndDate();
    $voteStartDate = $event->getStartDate();

    // check if the data of event has finished or not open for vote
    if (!$dataUtils->verifyEndDateEvent($voteEndDate)){
        echo "<br><br>";
        echo "<div class='alert alert-danger'>
        <strong>Event closed!</strong>
    </div>";
        exit();

    } else if (!$dataUtils->verifyStartDateEvent($voteStartDate)){
        echo "<br><br>";
        echo "<div class='alert alert-danger'>
        <strong>The event it's not available yet!</strong>
    </div>";
        exit();
    }

    // check if voter has made the vote
    $voteService = new VoteService();
    $hasVoted = $voteService->hasVoted($voter->getIdUser(), $event->getIdEvent());

    if ($hasVoted){
        header("Location: {$home_url}views/#.php");
        exit();

    }
//    else {
//
//        if ($event->getPublic() == 0){
//
//            echo "<div class='alert alert-danger'>
//                    <strong>Public event! You were selected for a private event!</strong>
//                </div>";
//
//        } else {
//            header("Location: {$home_url}controller/voteController.php?action=login_success");
//
//        }
//    }
}

//if (!$user->accessCodeExists()){
//    die("ERROR: Access code not found.");
//}

else {

    // update status to verify user code
    $user->status=1;
    $user->updateStatusByAccessCode();

    header("Location: {$home_url}login.php?action=email_verified");
}
?>