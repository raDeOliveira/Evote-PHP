<?php

// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "../admin/login_checker.php";

// include classes
include '../config/Database.php';
include '../objects/User.php';
include '../model/Event.php';
include '../service/EventService.php';
include '../repository/EventRepository.php';
include "../admin/layout_head.php";

$page_title = "edit-event";

// get database connection
$database = new Database();
$db = $database->getConnection();

$event = new Event();
if (isset($_GET['id_event'])){

    $idEvent = $_GET['id_event'];
    $eventService = new EventService();
    $event = $eventService->getEventById($idEvent);

}

//  received the update form
if (isset($_POST['edit-event'])){

    $eventName = $_POST['event-name'];
    $startDate = $_POST['start-date'];
    $endDate = $_POST['end-date'];
    $eventDescription = $_POST['event-description'];
    $typeDocument = $_POST['type-document'];

    // construct the voter model
    $eventToUpdate = new Event();
    $eventToUpdate->setIdEvent($event->getIdEvent());
    $eventToUpdate->setNameEvent($eventName);
    $eventToUpdate->setStartDate($startDate);
    $eventToUpdate->setEndDate($endDate);
    $eventToUpdate->setDescription($eventDescription);
    $eventToUpdate->setTypeDocument($typeDocument);

    // send the voter to be updated
    $eventService = new EventService();
    $eventService->updateEvent($eventToUpdate);

    //header("Refresh:0");
    header("Location: {$home_url}admin/read_events.php");

}

?>

    <br><br><br><br>
    <h4 class='text-align-center'>Edit event</h4>
    <hr style="border: solid">
    <form method="post" id='custom-color-table' enctype="multipart/form-data">
    <div class = "w-100 p-3">
        <div class="form-group">
            <label for="exampleFormControlInput1">Event title</label>
            <input id="exampleFormControlInput1" type='text' placeholder="Event title" name='event-name' class="form-control" required value="<?php echo $event->getNameEvent() ?>" />
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput2">Start of votation</label>
            <input id="exampleFormControlInput2" type='date' name='start-date' class="form-control" required value="<?php echo $event->getStartDate() ?>" />
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput3">End of votation</label>
            <input id="exampleFormControlInput3" type='date' name='end-date' class='form-control' required value="<?php echo $event->getEndDate() ?>" />
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput4">Associate type of document</label>
            <input id="exampleFormControlInput4" type='text' placeholder="Type of document" name='type-document' class='form-control' required value="<?php echo $event->getTypeDocument() ?>" />
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Event description</label>
            <textarea id="exampleFormControlTextarea1" placeholder="Event description" name='event-description' class='form-control' required ><?php echo $event->getDescription() ?></textarea>
        </div>

        <button id="create-back-button" type="submit" name="edit-event" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span> Save
        </button>
        <a id="create-back-button" href="../admin/read_events.php" class="btn btn-primary active" role="button">Back</a>
    </div>
    </form>
</div>

<?php
include "../layout_foot.php";




