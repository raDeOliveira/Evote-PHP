<?php


class Event {

    private $idEvent;
    private $nameEvent;
    private $startDate;
    private $endDate;
    private $description;
    private $typeDocument;

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
    public function getNameEvent()
    {
        return $this->nameEvent;
    }

    /**
     * @param mixed $nameEvent
     */
    public function setNameEvent($nameEvent)
    {
        $this->nameEvent = $nameEvent;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTypeDocument()
    {
        return $this->typeDocument;
    }

    /**
     * @param mixed $typeDocument
     */
    public function setTypeDocument($typeDocument): void
    {
        $this->typeDocument = $typeDocument;
    }










}