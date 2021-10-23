<?php

class EventRepository {

    // get events by id
    function getAllEvents() {

        $db = new Database();
        $db->getConnection();

        $query = "SELECT * FROM event";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        $event = $stmt->fetchAll();

        return $event;

    }

    // function to get events by id
    function getEventById($idEvent) {

        $event = new Event();

        $query = "SELECT * FROM event WHERE id_event =  '". $idEvent."' ";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch()) {

            $event = new Event();

            $event->setIdEvent($row["id_event"]);
            $event->setNameEvent($row["event_name"]);
            $event->setStartDate($row["start_date"]);
            $event->setEndDate($row["end_date"]);
            $event->setDescription($row["event_description"]);
            $event->setTypeDocument($row["type_document"]);
        }
        $db = null; // closes the DB.

        return $event;
    }

    // create event without CSV
    function createEvent(Event $event, array $lstCandidates){

        // get database connection
        $database = new Database();
        $res = $database->getConnection();

        try {
            $res->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $res->beginTransaction();

            // insert the event
            $name        = $event->getNameEvent();
            $startDate   = $event->getStartDate();
            $endDate     = $event->getEndDate();
            $description = $event->getDescription();
            $typeDocument = $event->getTypeDocument();

            $query = "INSERT INTO event(event_name, start_date, end_date, type_document, event_description) 
            VALUES ('".$name."', '".$startDate."', '".$endDate."', '".$typeDocument."', '".$description."')";

            $stmt = $res->prepare($query);
            $stmt->execute();
            $lastId = $res->lastInsertId();
            $event->setIdEvent($lastId);

            foreach ($lstCandidates as $candidate){

                $query = "INSERT INTO candidate (name_candidate) Values (?)";
                $stmt = $res->prepare($query);
                $stmt->execute ([$candidate->getNameCandidate()]);

                $lastId = $res->lastInsertId();
                $candidate->setIdCandidate($lastId);

                $candidateEvent = new CandidateEvent();
                $candidateEvent->setIdEvent($event->getIdEvent());
                $candidateEvent->setIdCandidate($candidate->getIdCandidate());

                $query = "INSERT INTO candidate_event (id_candidate, id_event) Values (?, ?)";
                $stmt = $res->prepare($query);
                $stmt->execute ([$candidateEvent->getIdCandidate(), $candidateEvent->getIdEvent()]);

                $candidateEvent->setIdCandidate($res->lastInsertId());

                $lstCandidateEvents [] = $candidateEvent;

            }

            // insert the voters
//            $lstVoterEvents = null;
//
//                $query = "INSERT INTO user (name_user, email_user, password, nidentificacao_user, docidentifica_user, access_code, status, created, modified)";
//                $query .= " Values ";
//                $query .= "(?,?,?,?,?,?,?,?,?)";
//
//                $stmt = $res->prepare($query);
//                $stmt->execute ([
//                    $voter->getNameUser(),
//                    $voter->getEmailUser(),
//                    $voter->getPassword(),
//                    $voter->getNidenficacaoUser(),
//                    $voter->getDocidenficaUser(),
//                    $voter->getAccessCode(),
//                    $voter->getStatus(),
//                    $voter->getCreated(),
//                    $voter->getModified()
//                ]);
//
//                $lastId = $res->lastInsertId();
//                $voter->setIdUser($lastId);
//
//                // insert associations voter_event
//                $voterEvent = new VoterEvent();
//                $voterEvent->setIdEvent($event->getIdEvent());
//                $voterEvent->setIdUser($voter->getIdUser());
//
//                $query = "INSERT INTO voter_event (id_user, id_event) Values (?,?)";
//
//                $stmt = $res->prepare($query);
//
//                $stmt->execute ( [$voterEvent->getIdUser(), $voterEvent->getIdEvent()] );
//
//                $voterEvent->setIdUserEvent($res->lastInsertId());
//
//                $lstVoterEvents[] = $voterEvent;

            $res->commit();

//            $voterRepository = new VoterRepository();
//            $voterRepository->loopUsersMail($event->getIdEvent());

            echo "<div class='alert alert-success'>Event created!</div>";

            $_POST=array();

            return $event;

        } catch (Exception $e) {
            $res->rollBack();
            echo "Failed rollback the operation: " . $e->getMessage();
        }
    }

    // add single voter
    function addVoterToEvent(Event $event, Voters $voter){

        // get database connection
        $database = new Database();
        $res = $database->getConnection();

        try {
            $res->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $res->beginTransaction();

            $query = "INSERT INTO user (name_user, email_user, password, nidentificacao_user, type_document, access_code, status, created, modified)";
            $query .= " Values ";
            $query .= "(?,?,?,?,?,?,?,?,?)";

            $stmt = $res->prepare($query);
            $stmt->execute ([
                $voter->getNameUser(),
                $voter->getEmailUser(),
                $voter->getPassword(),
                $voter->getNidenficacaoUser(),
                $voter->getTypeDocument(),
                $voter->getAccessCode(),
                $voter->getStatus(),
                $voter->getCreated(),
                $voter->getModified()
            ]);

            $lastId = $res->lastInsertId();
            $voter->setIdUser($lastId);

            // insert associations voter_event
            $voterEvent = new VoterEvent();
            $voterEvent->setIdEvent($event->getIdEvent());
            $voterEvent->setIdUser($voter->getIdUser());

            $query = "INSERT INTO voter_event (id_user, id_event) Values (?,?)";

            $stmt = $res->prepare($query);

            $stmt->execute ( [$voterEvent->getIdUser(), $voterEvent->getIdEvent()] );

            $voterEvent->setIdUserEvent($res->lastInsertId());

            $res->commit();

            return $voterEvent;

        } catch (Exception $e) {
            $res->rollBack();
            echo "Failed rollback the operation: " . $e->getMessage();
        }
    }

    // create bulk event witgh CSV
    function createBulkEvent(Event $event, array $lstCandidates, array $lstVoters){

        // get database connection
        $database = new Database();
        $res = $database->getConnection();

        try {
            $res->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $res->beginTransaction();

            // insert the event
            $name        = $event->getNameEvent();
            $startDate   = $event->getStartDate();
            $endDate     = $event->getEndDate();
            $description = $event->getDescription();

            $query = "INSERT INTO event(event_name, start_date, end_date, event_description) 
            VALUES ('".$name."', '".$startDate."', '".$endDate."', '".$description."')";

            $stmt = $res->prepare($query);
            $stmt->execute();
            $lastId = $res->lastInsertId();
            $event->setIdEvent($lastId);

            // insert the candidates
            $lstCandidateEvents = null;
            foreach ($lstCandidates as $candidate){

                $query = "INSERT INTO candidate (name_candidate) Values (?)";
                $stmt = $res->prepare($query);
                $stmt->execute ([$candidate->getNameCandidate()]);

                $lastId = $res->lastInsertId();
                $candidate->setIdCandidate($lastId);

                $candidateEvent = new CandidateEvent();
                $candidateEvent->setIdEvent($event->getIdEvent());
                $candidateEvent->setIdCandidate($candidate->getIdCandidate());

                $query = "INSERT INTO candidate_event (id_candidate, id_event) Values (?, ?)";
                $stmt = $res->prepare($query);
                $stmt->execute ([$candidateEvent->getIdCandidate(), $candidateEvent->getIdEvent()]);

                $candidateEvent->setIdCandidate($res->lastInsertId());

                $lstCandidateEvents [] = $candidateEvent;
            }

            // insert the voters
            $lstVoterEvents = null;
            foreach ($lstVoters as $voter){

                $query = "INSERT INTO user (name_user, email_user, password, nidentificacao_user, docidentifica_user, access_code, status, created, modified)";
                $query .= " Values ";
                $query .= "(?,?,?,?,?,?,?,?,?)";

                $stmt = $res->prepare($query);
                $stmt->execute ([
                    $voter->getNameUser(),
                    $voter->getEmailUser(),
                    $voter->getPassword(),
                    $voter->getNidenficacaoUser(),
                    $voter->getDocidenficaUser(),
//                    $voter->getAccessLevel(),
                    $voter->getAccessCode(),
                    $voter->getStatus(),
                    $voter->getCreated(),
                    $voter->getModified()
                ]);

                $lastId = $res->lastInsertId();
                $voter->setIdUser($lastId);

                // insert associations voter_event
                $voterEvent = new VoterEvent();
                $voterEvent->setIdEvent($event->getIdEvent());
                $voterEvent->setIdUser($voter->getIdUser());

                $query = "INSERT INTO voter_event (id_user, id_event) Values (?,?)";

                $stmt = $res->prepare($query);

                $stmt->execute ( [$voterEvent->getIdUser(), $voterEvent->getIdEvent()] );

                $voterEvent->setIdUserEvent($res->lastInsertId());

                $lstVoterEvents[] = $voterEvent;

                // loop arrays userEvents & CandidateEvents

//            foreach ($lstVoterEvents as $voterEvents){
//            foreach ($lstCandidateEvents as $candidateEvents) {
//
//                    if ($candidateEvents->getIdEvent() === $event->getIdEvent()){
//
//                        $candidateVoter = new CandidateVoter();
//                        $candidateVoter->setIdVoter($voterEvent->getIdUser());
//                        $candidateVoter->setIdCandidate($candidateEvents->getIdCandidate());
//                        $candidateVoter->setIdEvent($candidateEvents->getIdEvent());
//
//                        $query = "INSERT INTO candidate_voter (id_voter, id_candidate, id_event) Values (?, ?, ?)";
//
//                        $stmt = $res->prepare($query);
//
//                        $stmt->execute([
//                            $candidateVoter->getIdVoter(),
//                            $candidateVoter->getIdCandidate(),
//                            $candidateVoter->getIdEvent()
//                        ]);
//
//                    } else {
//                        // nothing
//                    }
//            }
            }

            $res->commit();

            // TODO mail comentado
            $voterRepository = new VoterRepository();
            $voterRepository->loopUsersMail($event->getIdEvent());

            echo "<div class='alert alert-success'>Event created!</div>";

            $_POST=array();

            return $event;

        } catch (Exception $e) {
            $res->rollBack();
            echo "Failed rollback the operation: " . $e->getMessage();
        }

    }

    // update event
    function updateEvent(Event $event){

        $query = "UPDATE event SET event_name=?, start_date=?, end_date=?, event_description=?, type_document=? WHERE id_event = '".$event->getIdEvent()."' ";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute([
            $event->getNameEvent(), $event->getStartDate(), $event->getEndDate(),
            $event->getDescription(), $event->getTypeDocument()
        ]);

        $event = new Event();
        while ($row = $stmt->fetch()) {

            $event->setIdEvent($row["id_event"]);
            $event->setNameEvent($row["name_event"]);
            $event->setStartDate($row["start_date"]);
            $event->setEndDate($row["end_date"]);
            $event->setDescription($row["event_description"]);
            $event->setTypeDocument($row["type-document"]);
        }
        return $event;
    }

    // read all events
    function readAllEvents() {

        $db = new Database();
        $db->getConnection();

        $query = "SELECT * FROM event";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        $event = $stmt->fetchAll();

        return $event;
    }

    function getCandidateEvent() {

        $query = "select c.name_candidate, c.id_candidate, event_name from candidate c
                join candidate_event ce ON c.id_candidate = ce.id_candidate
                join event e on ce.id_event = e.id_event";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        $lstResults = $stmt->fetchAll();

        return $lstResults;

    }

    function getEventByVoter ($emailVoter) {

        $query = "select * from `user` u 
join voter_event ve on u.id_user = ve.id_user
join event e on ve.id_event = e.id_event 
where u.email_user = '".$emailVoter."' ";

        $db = new Database();
        $res = $db->getConnection();

        $stmt = $res->prepare($query);
        $stmt->execute();

        $lstResults = $stmt->fetchAll();

        return $lstResults;

    }

}