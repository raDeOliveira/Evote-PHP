<?php
// core configuration
include_once "../config/core.php";
include_once '../config/Database.php';

include_once "../admin/login_checker.php";
include_once '../admin/layout_head.php';

include_once '../objects/User.php';

include_once "../repository/EventRepository.php";

include_once "../utils/Utils.php";

include_once "../model/Voters.php";
include_once "../model/Event.php";
include_once "../model/VoterEvent.php";
include_once "../model/CandidateEvent.php";

include_once "../service/VoterService.php";
include_once "../service/EventService.php";

include_once "../repository/VoterRepository.php";

// set page title
$page_title = "createVoter";

// get database connection
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if (isset($_POST['create-voter'])) {

    $idEvent = $_POST['select-event'];
    $typeDocument = $_POST['docidentifica_user'];

    if ($idEvent === null){
        return printf("Need to choose an event.");
    }

    $eventService = new EventService();
    $event = $eventService->getEventById($idEvent);

    $voter2 = new Voters();
    $voter2->setNameUser($_POST['name_user']);
    $voter2->setEmailUser($_POST['email_user']);
    $voter2->setNidenficacaoUser($_POST['nidentificacao_user']);
    $voter2->setTypeDocument($typeDocument);

    // hash the voter password
    $voterPassword = $_POST['password_user'];
    $_SESSION['voter-password'] = $voterPassword;
    $passVoter = password_hash($voterPassword, PASSWORD_BCRYPT);
    $voter2->setPassword($passVoter);

    $voterService = new VoterService();

    // create single voter by form and create event
    $voter2 = $voterService->createVoter($voter2);
    $eventService->addVoterToEvent($event, $voter2);

    $voterRepository = new VoterRepository();
    $voterRepository->sendVoteVerificationEmail($event->getIdEvent());

}

?>
<br>
<h4 class='text-align-center'>Create voter</h4>
<hr style="border: solid">

<!-- create voter form -->
<form method="post" action="createVoter.php" id='custom-color-table' enctype="multipart/form-data" onsubmit="return checkForm(this);">
    <div class = "w-100 p-3">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Choose Event</label>
            <select id="exampleFormControlSelect1" name="select-event" class="form-control">
                <option value="-1">Select option</option>
                <?php
                $eventService = new EventService();
                $lstEvents = $eventService->getAllEvents();

                foreach ($lstEvents as $event){
                    echo "<option value='{$event['id_event']}'>{$event['event_name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput1">Name</label>
            <input id="exampleFormControlInput1" type='text' placeholder="Name" name='name_user' class='form-control' required value="<?php echo isset($_POST['name_user']) ? htmlspecialchars($_POST['name_user'], ENT_QUOTES) : "";  ?>"/>
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput2">Password</label>
            <input id="exampleFormControlInput2" type='password' placeholder="Password" name='password_user' class='form-control' required value="<?php echo isset($_POST['password_user']) ? htmlspecialchars($_POST['password_user'], ENT_QUOTES) : "";  ?>"/>
        </div>

        <!-- to show requirements of password strength -->
        <div id="message">
            <h3>Password must contain the following:</h3>
            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
            <p id="number" class="invalid">A <b>number</b></p>
            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput3">Retype password</label>
            <input id = "exampleFormControlInput3" type='password' placeholder="Retype Password" name='password_user2' class='form-control' required value="<?php echo isset($_POST['password_user2']) ? htmlspecialchars($_POST['password_user2'], ENT_QUOTES) : "";  ?>"/>
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput4">Email</label>
            <input id="exampleFormControlInput4" type='email' placeholder="Email" name='email_user' class='form-control' required value="<?php echo isset($_POST['email_user']) ? htmlspecialchars($_POST['email_user'], ENT_QUOTES) : "";  ?>"/>
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput5">Identification number</label>
            <input id="exampleFormControlInput5" type='text' placeholder="Identification number" name='nidentificacao_user' class='form-control' required value="<?php echo isset($_POST['nidentificacao_user']) ? htmlspecialchars($_POST['nidentificacao_user'], ENT_QUOTES) : "";  ?>"/>
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect2">Please select type of document</label>
            <select name="docidentifica_user" id="exampleFormControlSelect2" class="form-control">
                <option value="-1">Select option</option>
                <?php
                $eventService = new EventService();
                $lstEvents = $eventService->getAllEvents();

                foreach ($lstEvents as $event){
                    echo "<option value='{$event['type_document']}'>{$event['type_document']}</option>";
                }
                ?>
            </select>
            <br>
            <button id="create-voter-button" type="submit" name="create-voter" class="btn btn-primary" >
                <span class="glyphicon glyphicon-plus"></span> Create
            </button>
        </div>
    </div>
</form>

    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <h1 class="col-12 modal-title text-center">ERROR</h1>
                </div>
                    <h4 class="col-12 modal-body text-center"></h4>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- password strength scripts -->
<script>
    // check requirements while typing password
    var myInput = document.getElementById("exampleFormControlInput2");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // when the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    }
    // when the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    }
    // when the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // validate lowercase letters by regex
        var lowerCaseLetters = /[a-z]/g;
        if(myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }
        // validate capital letters by regex
        var upperCaseLetters = /[A-Z]/g;
        if(myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }
        // validate numbers by regex
        var numbers = /[0-9]/g;
        if(myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }
        // validate length
        if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }

    // validate password requirements before submitting on the client-side
    function checkForm(form) {
        // check if password field it's empty and/or if it's equal to retype password
        if(form.password_user.value !== "" && form.password_user.value === form.password_user2.value) {
            if(form.password_user.value.length < 8) {
                window.alert = function() {
                    event.preventDefault();
                    $("#myModal .modal-body").text(arguments[0]);
                    $("#myModal").modal('show');
                };
                alert("Password must contain at least eight characters!");
                form.password_user.focus();
                return false;
            }
            // must contain at least one number
            valid = /[0-9]/;
            if(!valid.test(form.password_user.value)) {
                window.alert = function() {
                    event.preventDefault();
                    $("#myModal .modal-body").text(arguments[0]);
                    $("#myModal").modal('show');
                };
                alert("Password must contain at least one number (0-9)!");
                form.password_user.focus();
                return false;
            }
            // must contain at least one lowercase letter
            valid = /[a-z]/;
            if(!valid.test(form.password_user.value)) {
                window.alert = function() {
                    event.preventDefault();
                    $("#myModal .modal-body").text(arguments[0]);
                    $("#myModal").modal('show');
                };
                alert("Password must contain at least one lowercase letter (a-z)!");
                form.password_user.focus();
                return false;
            }
            // must contain at least one uppercase letter
            valid = /[A-Z]/;
            if(!valid.test(form.password_user.value)) {
                window.alert = function() {
                    event.preventDefault();
                    $("#myModal .modal-body").text(arguments[0]);
                    $("#myModal").modal('show');
                };
                alert("Password must contain at least one uppercase letter (A-Z)!");
                form.password_user.focus();
                return false;
            }
            // passwords don't match
        } else {
            window.alert = function() {
                event.preventDefault();
                $("#myModal .modal-body").text(arguments[0]);
                $("#myModal").modal('show');
            };

            // to catch focus on the form
            $('#myModal').on('shown.bs.modal', function () {
                form.password_user.focus();
            });
            alert("Passwords don't match!");

            return false;
        }
        return true;
    }
</script>

<?php
// include page footer HTML
include_once "../layout_foot.php";
?>