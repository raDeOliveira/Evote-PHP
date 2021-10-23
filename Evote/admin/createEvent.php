<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "../admin/login_checker.php";

include_once '../config/Database.php';
include_once '../objects/User.php';
include_once "../repository/EventRepository.php";
include_once "../utils/Utils.php";
include_once "../model/Voters.php";
include_once "../model/Event.php";
include_once "../model/Candidate.php";
include_once "../model/VoterEvent.php";
include_once "../model/CandidateEvent.php";
include_once "../service/VoterService.php";
include_once "../service/EventService.php";
include_once "../service/CandidateService.php";
include_once "../repository/VoterRepository.php";

// set page title
$page_title = "createCandidate";

include_once '../admin/layout_head.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
$user = new User($db);


// create event
if (isset($_POST['create-event'])) {

    // create event object
    $event = new Event();
    $event->setNameEvent($_POST['event-name']);
    $event->setStartDate($_POST['start-date']);
    $event->setEndDate($_POST['end-date']);
    $event->setDescription($_POST['event-description']);
    $event->setTypeDocument($_POST['type-document']);

    $nameCandidate = $_POST['candidate-name'];
    $lstCandidates2 = array();

    foreach ($nameCandidate as $key => $candidate) {

        // create event object
        $candidateObject = new Candidate();
        $candidateObject->setNameCandidate($candidate);

        $lstCandidates2 [] = $candidateObject;

    }

    $eventService = new EventService();
    $eventService->createEvent($event, $lstCandidates2);

}

?>

<br>
<h4 class='text-align-center'>Create event</h4>
<hr style="border: solid">

<!--create event form-->
<form method="post" action="createEvent.php" id='custom-color-table' enctype="multipart/form-data">
    <div class = "w-100 p-3">
        <div class="form-group">
            <label for="exampleFormControlInput1">Event title</label>
            <input id="exampleFormControlInput1" type='text' placeholder="Event title" name='event-name' class="form-control form-control-lg" required value="<?php echo isset($_POST['event-name']) ? htmlspecialchars($_POST['event-name'], ENT_QUOTES) : "";  ?>" />
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput2">Start of votation</label>
            <input id="exampleFormControlInput2" type='date' name='start-date' class="form-control form-control-lg" required value="<?php echo isset($_POST['start-date']) ? htmlspecialchars($_POST['start-date'], ENT_QUOTES) : "";  ?>" />
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput3">End of votation</label>
            <input id="exampleFormControlInput3" type='date' name='end-date' class='form-control' required value="<?php echo isset($_POST['end-date']) ? htmlspecialchars($_POST['end-date'], ENT_QUOTES) : "";  ?>" />
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput4">Associate type of document</label>
            <input id="exampleFormControlInput4" type='text' placeholder="Type of document" name='type-document' class='form-control' required value="<?php echo isset($_POST['type-document']) ? htmlspecialchars($_POST['type-document'], ENT_QUOTES) : "";  ?>" />
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Event description</label>
            <textarea id="exampleFormControlTextarea1" placeholder="Event description" name='event-description' class='form-control' required="<?php echo isset($_POST['event-description']) ? htmlspecialchars($_POST['event-description'], ENT_QUOTES) : "";  ?>"></textarea>
        </div>
    </div>

    <div class = "w-75 p-3">
        <div class="form-group container1">
            <h3>Add candidates</h3>
            <label for="exampleFormControlInput5"></label>
            <input id="exampleFormControlInput5" type='text' placeholder="Candidate name" name='candidate-name[]' class='form-control' required value="<?php echo isset($_POST['candidate-name']) ? htmlspecialchars($_POST['candidate-name'], ENT_QUOTES) : "";  ?>" />
            <br>
        </div>
    </div>

    <div class = "w-100 p-3">
        <button id="plus-candidate-voter" class="add_form_field btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
        <br><br>
        <button id="create-event-button" type="submit" name="create-event" class="btn btn-primary">
            <span style="text-align: center">Create event</span>
        </button>
    </div>
</form>

</div>

<?php

// include page footer HTML
include_once "../layout_foot.php";
?>

