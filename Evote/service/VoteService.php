<?php

class VoteService {

    // save vote
    function saveVote(Vote $vote) {
        include_once '../repository/VoteRepository.php';
        $voteRepository = new VoteRepository();
        $voteRepository->saveVote($vote);
    }

    // check if has voted
    function hasVoted($idVoter, $idEvent) {
        $voteRepository = new VoteRepository();
        return $voteRepository->validateVote($idVoter, $idEvent);
    }

    // count votes
    function countVotes($idEvent) {
        include_once '../repository/VoteRepository.php';
        $voteRepository = new VoteRepository();
        return $voteRepository->countVotes($idEvent);
    }

    // get public votes
    function getPublicVotes($idEvent) {
        $voteRepository = new VoteRepository();
        return $voteRepository->getPublicVotes($idEvent);
    }

    // check if vote was public
    function isPublic($idVoter, $idEvent) {
        $voteRepository = new VoteRepository();
        return $voteRepository->isPublic($idVoter, $idEvent);
    }

}