<?php

class VoteRepository {

    function saveVote(Vote $vote){

        $query = "INSERT INTO vote (id_event, id_candidate, id_voter, public_vote) VALUES (?,?,?,?) ";

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare($query);

        // execute the querys, also check if query was successful
        if ($stmt->execute([$vote->getIdEvent(), $vote->getIdCandidate(), $vote->getIdVoter(), $vote->getPublicVote()])) {
            return true;
        } else {
            $stmt->errorInfo();
            return false;
        }

    }

    // validate the vote
    /**
     * @param $idVoter
     * @param $idEvent
     * @return bool
     */
    function validateVote($idVoter, $idEvent){

        // add plus 1 vote to candidate
        $query2 = "SELECT v.id_vote from vote v where v.id_voter=? And v.id_event=?";

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        $stmt2 = $db->prepare($query2);
        $stmt2->execute([$idVoter, $idEvent]);

        if ($stmt2->rowCount() > 0) {
            return true;
        }else {
            return false;
        }
    }

    // count the votes
    function countVotes($idEvent){

        $query2 = "select c.name_candidate, count(v.id_vote) as total from candidate_event ce 
left join vote v on v.id_candidate = ce.id_candidate 
join candidate c on ce.id_candidate = c.id_candidate 
where ce.id_event = ? group by ce.id_candidate order by count(v.id_vote) desc;";

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        $stmt2 = $db->prepare($query2);
        $stmt2->execute([$idEvent]);

        $lstResults = $stmt2->fetchAll();

        return $lstResults;

    }

    // get ACCESS_CODE
    function getVoterAccessCode() {

        $query = "select access_code from user WHERE email_user = '".$_SESSION['email_user']."'";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // output data of each row
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            echo "Access Code: " . $row["access_code"];
            }

            return $row["access_code"];
        }
    }

    //get all public votes
    function getPublicVotes($idEvent) {

        $query = "SELECT * FROM `user` u 
                JOIN voter_event ve ON u.id_user = ve.id_user 
                JOIN vote v ON ve.id_user = v.id_voter
                JOIN candidate c ON v.id_candidate = c.id_candidate
                WHERE v.public_vote = 'Yes' and v.id_event = '".$idEvent."' ";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        $publicVotes = $stmt->fetchAll();

        return $publicVotes;

    }

    function isPublic($idVoter, $idEvent) {

        $query = "select * from `user` u 
join voter_event ve on u.id_user = ve.id_user 
join vote v on ve.id_user = v.id_voter 
where v.public_vote = 'Yes' and ve.id_user = '".$idVoter."' and ve.id_event = '".$idEvent."' ";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        $isPublic = $stmt->fetchAll();

        return $isPublic;

    }

}