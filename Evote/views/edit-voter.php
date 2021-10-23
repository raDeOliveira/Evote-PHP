<?php


// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "../admin/login_checker.php";

// include classes
include '../config/Database.php';
include '../objects/User.php';
include '../model/Voters.php';
include '../service/VoterService.php';
include '../repository/VoterRepository.php';
include "../admin/layout_head.php";

$page_title = "edit-voter";

// get database connection
$database = new Database();
$db = $database->getConnection();

$voter = new Voters();
if (isset($_GET['id_user'])){

    $idVoter = $_GET['id_user'];
    $voterService = new VoterService();
    $voter = $voterService->getVoterById($idVoter);

}

//  received the update form
if (isset($_POST['edit-user'])){

    $userName = $_POST['name_user'];
    $emailUser = $_POST['email_user'];
    $nidentificacaoUser = $_POST['nidentificacao_user'];
    $typeDocument = $_POST['docidentifica_user'];

    // construct the voter model
    $voterToUpdate = new Voters();
    $voterToUpdate->setIdUser($voter->getIdUser());
    $voterToUpdate->setNameUser($userName);
    $voterToUpdate->setEmailUser($emailUser);
    $voterToUpdate->setNidenficacaoUser($nidentificacaoUser);
    $voterToUpdate->setTypeDocument($typeDocument);

    // send the voter to be updated
    $voterService = new VoterService();
    $voterService->updateVoter($voterToUpdate);

    //header("Refresh:0");
    header("Location: {$home_url}admin/read_voters.php");

}

?>

    <br><br><br><br>
    <h4 class='text-align-center'>Edit voter</h4>
    <hr style="border: solid">
    <form method="post" id='custom-color-table' enctype="multipart/form-data">
        <div class = "w-100 p-3">
            <div class="form-group">
                <label for="exampleFormControlInput1">Name</label>
                <input id="exampleFormControlInput1" type='text' placeholder="Name" name='name_user' class='form-control' required value="<?php echo $voter->getNameUser() ?>"/>
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput3">Email</label>
                <input id="exampleFormControlInput3" type='email' placeholder="Email" name='email_user' class='form-control' required value="<?php echo $voter->getEmailUser() ?>"/>
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput4">Identification number</label>
                <input id="exampleFormControlInput4" type='text' placeholder="Identification number" name='nidentificacao_user' class='form-control' required value="<?php echo $voter->getNidenficacaoUser() ?>"/>
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput5">Type of document</label>
                <input id="exampleFormControlInput5" type='text' placeholder="Identification number" name='docidentifica_user' class='form-control' required value="<?php echo $voter->getTypeDocument() ?>"/>
            </div>

            <button id="create-back-button" type="submit" name="edit-user" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus"></span> Save
            </button>
        <a id="create-back-button" href="../admin/read_voters.php" class="btn btn-primary active" role="button">Back</a>

        </div>
    </form>
</div>

<?php
include "../layout_foot.php";




