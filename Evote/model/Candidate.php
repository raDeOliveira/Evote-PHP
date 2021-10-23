<?php


class Candidate {

    private $idCandidate;
    private $nameCandidate;

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
    public function getNameCandidate()
    {
        return $this->nameCandidate;
    }

    /**
     * @param mixed $nameCandidate
     */
    public function setNameCandidate($nameCandidate)
    {
        $this->nameCandidate = $nameCandidate;
    }



}