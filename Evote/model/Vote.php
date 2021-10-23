<?php


class Vote {

    private $idVote;
    private $idVoter;
    private $publicVote;
    private $idCandidate;
    private $idEvent;
    private $date_creation;

    /**
     * @return mixed
     */
    public function getIdVote()
    {
        return $this->idVote;
    }

    /**
     * @param mixed $idVote
     */
    public function setIdVote($idVote)
    {
        $this->idVote = $idVote;
    }

    /**
     * @return mixed
     */
    public function getIdVoter()
    {
        return $this->idVoter;
    }

    /**
     * @param mixed $idVoter
     */
    public function setIdVoter($idVoter)
    {
        $this->idVoter = $idVoter;
    }

    /**
     * @return mixed
     */
    public function getPublicVote()
    {
        return $this->publicVote;
    }

    /**
     * @param mixed $publicVote
     */
    public function setPublicVote($publicVote): void
    {
        $this->publicVote = $publicVote;
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

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param mixed $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }









}