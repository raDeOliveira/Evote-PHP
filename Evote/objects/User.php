<?php

class User{

    // database connection and table name
    private $conn;
    private $table_name = "user";

    // object properties
    public $id_user;
    public $name_user;
    public $email_user;
    public $password;
    public $access_level;
    public $access_code;
    public $status;
    public $vote;
    public $idEvent;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // check if given email exist in the database
    function emailExists(){

        $query = "SELECT id_user, name_user, email_user, password, access_level, status
                FROM " . $this->table_name . "
                WHERE email_user = ?
                LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email_user=htmlspecialchars(strip_tags($this->email_user));

        // bind given email value
        $stmt->bindParam(1, $this->email_user);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id_user = $row['id_user'];
            $this->name_user = $row['name_user'];
            $this->email_user = $row['email_user'];
            $this->access_level = $row['access_level'];
            $this->password = $row['password'];
            $this->status = $row['status'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }

    // read all user records for ADMIN
    function readAll($from_record_num, $records_per_page){

        // query to read all user records, with limit clause for pagination
        $query = "SELECT
            id_user,
            name_user,
            email_user,
            nidentificacao_user,
            docidentifica_user,
            access_level,
            created
            FROM " . $this->table_name . "
            ORDER BY id_user DESC
            LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind limit clause variables
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values
        return $stmt;
    }

    // check if given access_code exist in the database
    function accessCodeExists(){

        // query to check if access_code exists
        $query = "SELECT id_user
                FROM " . $this->table_name . "
                WHERE access_code = ?
                LIMIT 0,1";

        printf($query);

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->access_code=htmlspecialchars(strip_tags($this->access_code));

        printf("sanatized: " . $this->access_code);

        // bind given access_code value
        $stmt->bindParam(1, $this->access_code);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if access_code exists
        if($num>0){

            // return true because access_code exists in the database
            return true;
        }

        // return false if access_code does not exist in the database
        return false;

    }

    // used in email verification feature
    function updateStatusByAccessCode(){

        // update query
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE access_code = :access_code";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->access_code=htmlspecialchars(strip_tags($this->access_code));

        // bind the values from the form
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':access_code', $this->access_code);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // used for paging users for ADMIN
    public function countAll(){

        // query to select all user records
        $query = "SELECT id_user FROM " . $this->table_name . " ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // return row count
        return $num;
    }

    // function to import csv
    function openCsv() {
        $row = 1;
        if (($handle = fopen("teachers.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
//                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";
                }
            }
            fclose($handle);
        }
    }

    // function to import candidates CSV
    function importCandidatesCsv($fileName) {

        //$this->idsCandidates [] = '';

        include_once "../model/Candidate.php";
        $lstCandidates = null;
        if ($_FILES["file"]["size"] > 0) {

            $handle = fopen($fileName, "r");
            if ($handle) {
                while (($line = fgetcsv($handle)) !== false) {

                    $candidate = new Candidate();
                    $candidate->setNameCandidate($line[0]);

                    $lstCandidates [] = $candidate;

                }
                fclose($handle);
            }
        }
        //print_r($lstCandidates);
        return $lstCandidates;
    }

    // function to import users CSV
    function importUsersCsv($fileName) {

        include_once "../model/Voters.php";
        $lstUsers = null;
        if ($_FILES["file"]["size"] > 0) {

            $handle = fopen($fileName, "r");
            if ($handle) {
                while (($line = fgetcsv($handle)) !== false) {
                    try {

                        // set create date
                        $created = date('Y-m-d H:i:s');

                        // access code for email verification
                        $utils = new Utils();
                        $code = $utils->getToken();

                        // hash the password before saving to database
                        $password_hash = password_hash($code, PASSWORD_BCRYPT);

                        $user = new Voters();
                        $user->setNameUser($line[0]);
                        $user->setEmailUser($line[1]);
                        $user->setPassword($password_hash);
                        $user->setNidenficacaoUser($line[3]);
                        $user->setDocidenficaUser($line[4]);
                        $user->setAccessLevel($line[5]);
                        $user->setAccessCode($code);
                        $user->setStatus($line[7]);
                        $user->setCreated($created);
                        $user->setModified($line[9]);

                        $lstUsers [] = $user;

                    } catch (Exception $ex) {
                        echo $ex->getmessage();
                    }
                }
                fclose($handle);
            }
        }
        return $lstUsers;
    }


}