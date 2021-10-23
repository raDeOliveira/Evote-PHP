<?php
// core configuration
include_once "../config/core.php";
include_once "../voter/login_checker.php";
include_once '../config/database.php';
include_once '../objects/User.php';
include_once '../service/EventService.php';
include_once "../repository/EventRepository.php";
include_once "../repository/VoterRepository.php";
include_once "../model/Voters.php";

$page_title = "index";

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$user = new User($db);

// include page header HTML
include_once '../voter/layout_head.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// system date
$date = date("Y-m-d");
$_SESSION['d'] = $date;

// get voter id
$voterRepository = new VoterRepository();
$voter = $voterRepository->getVoterByEmail($_SESSION['email_user']);
$voterId = new Voters();
foreach ($voter as $v) {
    $voterId = $v['id_user'];
}

// get email voter
$voterEmail = $_SESSION['email_user'];
$idVoter = $voterId;

// get name voter
$nameVoter = $_SESSION['name_user'];

// get all candidates by id
$eventService = new EventService();
$lstEvents = $eventService->getEventByVoter($voterEmail);

?>

    <br><br><br><br>
    <h4 style="text-align: center">Welcome <?php echo $nameVoter ?> to eletronic voting</h4>
    <hr style="border: solid">
    <table id="custom-color-table" class="text-align-center table table-hover">
        <thead>
        <tr>
            <th scope="col">Event Name</th>
            <th scope="col">See results</th>
            <th scope="col">Vote</th>
        </tr>
        </thead>

        <?php foreach ($lstEvents as $event) { ?>

        <tbody>
        <tr>
            <td><?php echo $event['event_name'] ?></td>
            <td><a href='../voter/results.php?id_event=<?php echo $event['id_event'] ?>&id_user=<?php echo $idVoter ?>'>Results</a></td>
            <td><a href='../controller/voteController.php?id_event=<?php echo $event['id_event'] ?>&id_user=<?php echo $idVoter ?> '>Vote</a></td>
        </tr>

        <?php
        }
        ?>

        </tbody>
    </table>
</div>

 
 <?php
// include page footer HTML
include_once '../layout_foot.php';
?>