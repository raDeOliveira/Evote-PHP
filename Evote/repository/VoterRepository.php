<?php

class VoterRepository {

    // read all voters
    function readAllVoters() {

        $db = new Database();
        $db->getConnection();

        $query = "SELECT * FROM user";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        $voter = $stmt->fetchAll();

        return $voter;

    }

    // get voter by email
    function getVoterByEmail($emailVoter) {

        $db = new Database();
        $db->getConnection();

        $query = "SELECT * FROM user where email_user = '".$emailVoter."' ";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        $voter = $stmt->fetchAll();

        return $voter;

    }

    // function to get user ID
    function getVoterById($idUser) {

        $query = "SELECT * FROM user WHERE id_user = '".$idUser."' ";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch()) {

            $voter = new Voters();
            $voter->setIdUser($row["id_user"]);
            $voter->setNameUser($row["name_user"]);
            $voter->setEmailUser($row["email_user"]);
            $voter->setPassword($row["password"]);
            $voter->setNidenficacaoUser($row["nidentificacao_user"]);
            $voter->setTypeDocument($row["type_document"]);
            $voter->setAccessLevel($row["access_level"]);
            $voter->setAccessCode($row["access_code"]);
            $voter->setStatus($row["status"]);
            $voter->setCreated($row["created"]);
            $voter->setModified($row["modified"]);

        }

        return $voter;
    }

    // send vote confirmation
    function sendVoteConfirmationEmail($idVoter, $idEvent){

        $query = "select u.email_user, u.access_code, u.name_user from `user` u where u.id_user = '".$idVoter."' ";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $name = $row['name_user'];
                $code =  $row["access_code"];
                $voterEmail =  $row["email_user"];
            }
        }

        // call vote function
        $voterService = new VoterService();
        $nameCandidateVote = $voterService->getVoteById($idVoter);

        // call the event name
        $eventService = new EventService();
        $event = $eventService->getEventById($idEvent);
        $event = $event->getNameEvent();

        $subject = "Vote confirmation Email";
        $body = "Hi {$name}, your vote was confirmded, thank's.<br /><br />";

        $body .= "Your verification code is: <strong>{$code}</strong> <br /><br />";
        $body .= "Event: <strong>{$event}</strong> <br /><br />";
        $body .= "You voted in: <strong>{$nameCandidateVote}</strong> <br /><br />";

        $body .= "E@vote team";

        $utils = new Utils();
        $utils->sendPhpMail($voterEmail, $subject, $body);

    }

    // update voter
    function updateVoter(Voters $voters){

        $query = "UPDATE user SET name_user = ?, email_user=?, nidentificacao_user=?, type_document=? WHERE id_user = ? ";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute([
            $voters->getNameUser(), $voters->getEmailUser(), $voters->getNidenficacaoUser(), $voters->getTypeDocument(), $voters->getIdUser()
        ]);

        $voter = new Voters();
        while ($row = $stmt->fetch()) {

            $voter->setIdUser($row["id_user"]);
            $voter->setNameUser($row["name_user"]);
            $voter->setEmailUser($row["email_user"]);
            $voter->setPassword($row["password"]);
            $voter->setNidenficacaoUser($row["nidentificacao_user"]);
            $voter->setTypeDocument($row["docidentifica_user"]);
            $voter->setAccessLevel($row["access_level"]);
            $voter->setAccessCode($row["access_code"]);
            $voter->setStatus($row["status"]);
            $voter->setCreated($row["created"]);
            $voter->setModified($row["modified"]);

        }
        return $voter;
    }

    // loop users by eventId to get verification email
    function loopUsersMail($idEvent) {

        $query = "SELECT e.event_name, ve.id_user, u.name_user, u.email_user, u.access_code FROM user u
JOIN voter_event ve ON ve.id_user = u.id_user
JOIN event e ON e.id_event = ve.id_event
where e.id_event = ? and u.status = 0 ";

        $db = new Database();
        $rst = $db->getConnection();

        $stmt = $rst->prepare($query);
        $stmt->execute([$idEvent]);
        $mail = $stmt->fetchAll();

        foreach ($mail as $voter) {

            $home = "http://localhost/AppVoteATW/";
            $name = $voter['name_user'];
            $mail2 = $voter['email_user'];
            $access_code2 = $voter['access_code'];
            $nameEvent = $voter['event_name'];
            $idVoter = $voter['id_user'];

            $subject = "Verification Email";
            $body = "Hi {$name}, welcome to Eletronic voting.<br /><br />";
            $body .= "You're invited to join us in eletronic votation!<br/>";
            $body .= "Please click the following link to place your vote: {$home}verify.php?id_user={$idVoter}&id_event={$idEvent}&access_code={$access_code2} <br /><br />";
            $body .= "Name event: {$nameEvent} <br /><br />";
            $body .= "Many thank's";

            $utils = new Utils();
            $utils->sendPhpMail($mail2, $subject, $body);

            sleep(3);

        }
    }

    // send verification email
    function sendVoteVerificationEmail($idEvent){

        $query = "SELECT e.event_name, ve.id_user, u.name_user, u.email_user, u.access_code, password FROM user u
JOIN voter_event ve ON ve.id_user = u.id_user
JOIN event e ON e.id_event = ve.id_event
where e.id_event = ? and u.status = 0 ";

        $db = new Database();
        $rst = $db->getConnection();

        $stmt = $rst->prepare($query);
        $stmt->execute([$idEvent]);
        $mail = $stmt->fetchAll();

        foreach ($mail as $voter) {

            $home = "http://localhost/AppVoteATW/";
            $name = $voter['name_user'];
            $mail2 = $voter['email_user'];
//            $access_code2 = $voter['access_code'];
            $nameEvent = $voter['event_name'];
//            $idVoter = $voter['id_user'];
            $password = $_SESSION['voter-password'];

            $subject = "Verification Email";
            $body = "Hi {$name}, welcome to Eletronic voting.<br /><br />";
            $body .= "You're invited to join us in eletronic votation!<br/>";
//            $body .= "Please click the following link to place your vote: {$home}verify.php?id_user={$idVoter}&id_event={$idEvent}&access_code={$access_code2} <br /><br />";
            $body .= "Please click the following link to place your vote: {$home}login.php <br /><br />";
            $body .= "Name event: {$nameEvent} <br /><br />";
            $body .= "Username: {$mail2} <br /><br />";
            $body .= "Password: {$password} <br /><br />";
            $body .= "Many thank's";

            $utils = new Utils();
            $utils->sendPhpMail($mail2, $subject, $body);


        }

    }

    // get the vote
    function getVoteById($idVoter) {

    $query = "select c.name_candidate, c.id_candidate from `user` u
            join vote v on u.id_user = v.id_voter
            join candidate c on v.id_candidate = c.id_candidate
            where u.id_user = '".$idVoter."'";

    $db = new Database();
    $res = $db->getConnection();

    $stmt = $res->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nameCandidate = $row['name_candidate'];
        }
    }

    return $nameCandidate;
}

    // get voters by type of document
    function getVotersByTypeDocument($typeDocument) {

    $query = "select name_user from `user` u 
where u.type_document = '".$typeDocument."'";

    $db = new Database();
    $res = $db->getConnection();

    $stmt = $res->prepare($query);
    $stmt->execute();

    $lstVoters = $stmt->fetchAll();

    return $lstVoters;
}



}