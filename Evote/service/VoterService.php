<?php


class VoterService {

    // get voter by id
    function getVoterById($idUser) {
        $voterRepository = new VoterRepository();
        return $voterRepository->getVoterById($idUser);
    }

    // create voter
    function createVoter(Voters $voter){

        // set create date
        $created = date('Y-m-d H:i:s');

        // access code for email verification
        $utils = new Utils();
        $code = $utils->getToken();

        $voter->setAccessCode($code);
        $voter->setCreated($created);
        $voter->setStatus(0);

        return $voter;
    }

    // update voter
    function updateVoter(Voters $voter){
        $voterRepository = new VoterRepository();
        return $voterRepository->updateVoter($voter);
    }

    // function to import users CSV
    function importVotersCsv($fileName) {

        include_once "../model/Voters.php";
        $lstUsers = null;
        if ($_FILES["file"]["size"] > 0) {

            $handle = fopen($fileName, "r");
            if ($handle) {
                while (($line = fgetcsv($handle)) !== false) {
                    try {

                        // set create date
                        $created = date('Y-m-d H:i:s');

                        // access code for email verification
                        $utils = new Utils();
                        $code = $utils->getToken();

                        // hash the password before saving to database
                        $password_hash = password_hash($code, PASSWORD_BCRYPT);

                        $user = new Voters();
                        $user->setNameUser($line[0]);
                        $user->setEmailUser($line[1]);
                        $user->setPassword($password_hash);
                        $user->setNidenficacaoUser($line[3]);
                        $user->setDocidenficaUser($line[4]);
                        $user->setAccessLevel($line[5]);
                        $user->setAccessCode($code);
                        $user->setStatus($line[7]);
                        $user->setCreated($created);
//                        $user->setModified($line[9]);

                        $lstUsers [] = $user;

                    } catch (Exception $ex) {
                        echo $ex->getmessage();
                    }
                }
                fclose($handle);
            }
        }
        return $lstUsers;
    }

    // send vote confirmation email
    function sendVoteConfirmationEmail($idVoter, $idEvent) {
        $voterRepository = new VoterRepository();
        $voterRepository->sendVoteConfirmationEmail($idVoter, $idEvent);
    }

    // get vote by voter id
    function getVoteById($idVoter) {
        $voterRepository = new VoterRepository();
        return $voterRepository->getVoteById($idVoter);
    }

    // get voters by type of document
    function getVotersByTypeDocument($typeDocument) {
        $voterRepository = new VoterRepository();
        return $voterRepository->getVotersByTypeDocument($typeDocument);
    }


}