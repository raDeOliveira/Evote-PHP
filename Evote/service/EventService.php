<?php


class EventService {

    // get event id
    public function getEventById($idEvent){
        $eventRepository = new EventRepository();
        return $eventRepository->getEventById($idEvent);
    }

    // get event id
    public function getAllEvents(){
        $eventRepository = new EventRepository();
        return $eventRepository->getAllEvents();
    }

//    // create event
//    function createEvent(Event $event, array $lstCandidates){
//        include_once '../repository/EventRepository.php';
//        $eventRepository = new EventRepository();
//        $eventRepository->createEvent($event, $lstCandidates);
//    }

// create event
    function createEvent(Event $event, array $lstCandidates){
        include_once '../repository/EventRepository.php';
        $eventRepository = new EventRepository();
        $eventRepository->createEvent($event, $lstCandidates);
    }

    // add voter to event
    function addVoterToEvent(Event $event, Voters $voter){
        include_once '../repository/EventRepository.php';
        $eventRepository = new EventRepository();
        $voterEvent = $eventRepository->addVoterToEvent($event, $voter);

        $utils = new Utils();
//        $utils->sendMailtoUser($voterEvent);

        $_POST=array();

        echo "<div class='alert alert-success'>Voter added to event</div>";
    }

    // update event
    function updateEvent(Event $event){
        $eventRepository = new EventRepository();
        return $eventRepository->updateEvent($event);
    }

    // create event with CSV
    function createBulkEvent(Event $event, array $lstCandidates, array $lstVoters){
        $eventRepository = new EventRepository();
        $eventRepository->createBulkEvent($event, $lstCandidates, $lstVoters);
    }

    function getCandidateEvent() {
        $eventRepository = new EventRepository();
        return $eventRepository->getCandidateEvent();
    }

    function getEventByVoter($voterEmail) {
        $eventRepository = new EventRepository();
        return $eventRepository->getEventByVoter($voterEmail);
    }



}