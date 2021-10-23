<?php

class Utils{

    // generate access code
    function getToken($length=32){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
    }

    //encrypt access code
    function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    // send email using built in php mail function
    public function sendEmailViaPhpMail($send_to_email, $subject, $body){

        $from_name="E@vote";
        $from_email="E@vote";

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: {$from_name} <{$from_email}> \n";

        if(mail($send_to_email, $subject, $body, $headers)){
            return true;
        }
        return false;
    }

    // send email to users to start votation
    public function sendPhpMail($send_to_email, $subject, $body){

        $from_name="E@vote";
        $from_email="E@vote";

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: {$from_name} <{$from_email}> \n";

        if(mail($send_to_email, $subject, $body, $headers)){
            return true;
        }
        return false;
    }

    // loop users by eventId to get verification email
    function sendMailtoUser(VoterEvent $voterEvent) {

        $query = "SELECT e.event_name, ve.id_user, u.name_user, u.email_user, u.access_code, ve.id_event FROM user u
                    JOIN voter_event ve ON ve.id_user = u.id_user
                    JOIN event e ON e.id_event = ve.id_event
                    where u.status = 0 and ve.id_user = '".$voterEvent->getIdUser()."'; 
                    ";

        $db = new Database();
        $rst = $db->getConnection();

        $stmt = $rst->prepare($query);
        $stmt->execute();
        $mail = $stmt->fetchAll();

        //var_dump($mail);

        foreach ($mail as $voter) {

            $home = "http://localhost/AppVoteATW/";
            $name = $voter['name_user'];
            $mail2 = $voter['email_user'];
            $access_code2 = $voter['access_code'];
            $nameEvent = $voter['event_name'];
            $idVoter = $voter['id_user'];
            $idEvent = $voter['id_event'];

            $subject = "Verification Email";
            $body = "Hi {$name}, welcome to Eletronic voting.<br /><br />";
            $body .= "You're invited to join us in eletronic votation!<br/>";
            $body .= "Please click the following link to place your vote: {$home}verify.php?id_user={$idVoter}&id_event={$idEvent}&access_code={$access_code2} <br /><br />";
            $body .= "Name event: {$nameEvent} <br /><br />";
            $body .= "Many thank's";

            $utils = new Utils();
            $utils->sendPhpMail($mail2, $subject, $body);
            //$this->sendPhpMail($mail2, $subject, $body);

            //sleep(3);

        }
    }

}
