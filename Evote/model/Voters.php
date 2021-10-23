<?php

class Voters {

    private $idUser;
    private $nameUser;
    private $emailUser;
    private $password;
    private $nidenficacaoUser;
    private $typeDocument;
    private $accessLevel;
    private $accessCode;
    private $status;
    private $created;
    private $modified;

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
    public function getNameUser()
    {
        return $this->nameUser;
    }

    /**
     * @param mixed $nameUser
     */
    public function setNameUser($nameUser)
    {
        $this->nameUser = $nameUser;
    }

    /**
     * @return mixed
     */
    public function getEmailUser()
    {
        return $this->emailUser;
    }

    /**
     * @param mixed $emailUser
     */
    public function setEmailUser($emailUser)
    {
        $this->emailUser = $emailUser;
    }


    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getNidenficacaoUser()
    {
        return $this->nidenficacaoUser;
    }

    /**
     * @param mixed $nidenficacaoUser
     */
    public function setNidenficacaoUser($nidenficacaoUser)
    {
        $this->nidenficacaoUser = $nidenficacaoUser;
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



    /**
     * @return mixed
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }

    /**
     * @param mixed $accessLevel
     */
    public function setAccessLevel($accessLevel)
    {
        $this->accessLevel = $accessLevel;
    }

    /**
     * @return mixed
     */
    public function getAccessCode()
    {
        return $this->accessCode;
    }

    /**
     * @param mixed $accessCode
     */
    public function setAccessCode($accessCode)
    {
        $this->accessCode = $accessCode;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }


}