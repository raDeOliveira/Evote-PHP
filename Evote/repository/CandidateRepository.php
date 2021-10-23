<?php

class CandidateRepository {

// function to get candidate by id
function getAllCandidatesByIdEvent($idEvent) {

//    $query = "SELECT * FROM candidate c JOIN candidate_event ce ON c.id_candidate = ce.id_candidate WHERE ce.id_event = '".$idEvent."' ";
    $query = "select * from candidate c 
join candidate_event ce on c.id_candidate = ce.id_candidate 
join event e on ce.id_event = e.id_event 
where e.id_event = '".$idEvent."' ";

    $db = new Database();
    $res = $db->getConnection();

    $stmt = $res->prepare($query);
    $stmt->execute();

    $lstCandidates = null;
    while ($row = $stmt->fetch()) {

        $candidate = new Candidate();

        $candidate->setIdCandidate($row["id_candidate"]);
        $candidate->setNameCandidate($row["name_candidate"]);

        $lstCandidates [] = $candidate;

    }

    $db = null;

    return $lstCandidates;

}

// read all candidates
    function readAllCandidate() {

        $db = new Database();
        $db->getConnection();

        $query = "SELECT * FROM candidate";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        $candidate = $stmt->fetchAll();

        return $candidate;
    }

// function to get candidate by id
    function getCandidateById($idUser) {

        $candidate = new Candidate();

        $query = "SELECT * FROM candidate WHERE id_candidate = " . $idUser;

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch()) {

            $candidate = new Candidate();

            $candidate->setIdCandidate($row["id_candidate"]);
            $candidate->setNameCandidate($row["name_candidate"]);

        }

        $db = null;

//        return $candidate->getIdCandidate();
        return $candidate;

    }

// update event
    function updateCandidate(Candidate $candidate){

        $query = "UPDATE candidate SET name_candidate = ? WHERE id_candidate = ?";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute([$candidate->getNameCandidate(), $candidate->getIdCandidate()]);

        $candidate = new Candidate();
        while ($row = $stmt->fetch()) {

            $candidate->setIdCandidate($row["id_candidate"]);
            $candidate->setNameCandidate($row["name_candidate"]);

        }

        return $candidate;
    }

    // add candidate
    function addCandidate(Candidate $candidate) {

        $query = "INSERT INTO candidate (name_candidate) Values (?)";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute ([$candidate->getNameCandidate()]);
//        $stmt->execute ($candidate->getNameCandidate());

        $lastId = $res->lastInsertId();
        $candidate->setIdCandidate($lastId);

//        $candidateEvent = new CandidateEvent();
//        $candidateEvent->setIdEvent($event->getIdEvent());
//        $candidateEvent->setIdCandidate($candidate->getIdCandidate());
//
//        $query = "INSERT INTO candidate_event (id_candidate, id_event) Values (?, ?)";
//        $stmt = $res->prepare($query);
//        $stmt->execute ([$candidateEvent->getIdCandidate(), $candidateEvent->getIdEvent()]);
//
//        $candidateEvent->setIdCandidate($res->lastInsertId());
//
//        $lstCandidateEvents [] = $candidateEvent;

        return $candidate;
    }


}