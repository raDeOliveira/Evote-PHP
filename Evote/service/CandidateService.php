<?php

include_once '../repository/CandidateRepository.php';

class CandidateService {

    // get event id
    public function getCandidateById($idCandidate){
        $candidateRepository = new CandidateRepository();
        return $candidateRepository->getCandidateById($idCandidate);
    }

    // read all candidates access levels
    function getAllCandidatesByIdEvent($idEvent) {
        $candidateRepository = new CandidateRepository();
        return $candidateRepository->getAllCandidatesByIdEvent($idEvent);
    }

    // update event
    function updateCandidate(Candidate $candidate){
        $candidateRepository = new CandidateRepository();
        return $candidateRepository->updateCandidate($candidate);
    }

    function addCandidate(Candidate $candidate) {
        $candidateRepository = new CandidateRepository();
        return $candidateRepository->addCandidate($candidate);
    }

}