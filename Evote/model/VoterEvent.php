<?php


class VoterEvent {

    private $idUserEvent;
    private $idUser;
    private $idEvent;

    /**
     * @return mixed
     */
    public function getIdUserEvent()
    {
        return $this->idUserEvent;
    }

    /**
     * @param mixed $idUserEvent
     */
    public function setIdUserEvent($idUserEvent)
    {
        $this->idUserEvent = $idUserEvent;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
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