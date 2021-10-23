<?php


class CandidateEvent
{

    private $idCandidateEvent;
    private $idCandidate;
    private $idEvent;

    /**
     * @return mixed
     */
    public function getIdCandidateEvent()
    {
        return $this->idCandidateEvent;
    }

    /**
     * @param mixed $idCandidateEvent
     */
    public function setIdCandidateEvent($idCandidateEvent)
    {
        $this->idCandidateEvent = $idCandidateEvent;
    }

    /**
     * @return mixed
     */
    public function getIdCandidate()
    {
        return $this->idCandidate;
    }

    /**
     * @param mixed $idCandidate
     */
    public function setIdCandidate($idCandidate)
    {
        $this->idCandidate = $idCandidate;
    }

    /**
     * @return mixed
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * @param mixed $idEvent
     */
    public function setIdEvent($idEvent)
    {
        $this->idEvent = $idEvent;
    }



}