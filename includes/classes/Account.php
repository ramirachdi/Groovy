<?php
class Account {

    public $errorArray;
    protected PDO $con;

    public function __construct() {
        $this->con=connexionBD::getInstance();
        $this->errorArray = array();
    }

    public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
        $this->validateUsername($un);
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateEmails($em, $em2);
        $this->validatePasswords($pw, $pw2);

        if (empty($this->errorArray))
        {
            return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
        }
        else
        {
            return false;
        }
    }

    public function insertUserDetails($un, $fn, $ln, $em, $pw)
    {
        $userRepository=new userRepository();
        $params=array($un, $fn, $ln, $em, $pw);
        $result=$userRepository->create($params);

        return($result);
    }

    public function getError($error)
    {
        if (in_array($error,$this->errorArray))
        {
            return $error;
        }
        else
            return "";
    }

    private function validateUsername($un) {

        if(strlen($un) > 25 || strlen($un) < 5) {
            array_push($this->errorArray, "Your username must be between 5 and 25 characters");
            return;
        }

        $checkUsername=$this->con->query("select count(*) from users where username='$un'");

        if ($checkUsername->fetchColumn()!=0)
        {
            array_push($this->errorArray,"This username already exists");
            return;
        }

    }

    private function validateFirstName($fn) {
        if(strlen($fn) > 25 || strlen($fn) < 2) {
            array_push($this->errorArray, "Your first name must be between 2 and 25 characters");
            return;
        }
    }

    private function validateLastName($ln) {
        if(strlen($ln) > 25 || strlen($ln) < 2) {
            array_push($this->errorArray, "Your last name must be between 2 and 25 characters");
            return;
        }
    }

    private function validateEmails($em, $em2) {
        if($em != $em2) {
            array_push($this->errorArray, "Your emails don't match");
            return;
        }

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, "Email is invalid");
            return;
        }

        $checkEmail=$this->con->query("select count(*) from users where email='$em'");

        if ($checkEmail->fetchColumn()!=0)
        {
            array_push($this->errorArray,"This email already exists");
            return;
        }

    }

    private function validatePasswords($pw, $pw2) {

        if($pw != $pw2) {
            array_push($this->errorArray, "Your passwords don't match");
            return;
        }

        if(preg_match('/[^A-Za-z0-9]/', $pw)) {
            array_push($this->errorArray, "Your password can only contain numbers and letters");
            return;
        }

        if(strlen($pw) > 30 || strlen($pw) < 5) {
            array_push($this->errorArray, "Your password must be between 5 and 30 characters");
            return;
        }

    }

    public function login($un, $pw) {

        $pw=md5($pw);

        $checkLogin=$this->con->query("select count(*) from users where username='$un' AND password='$pw'");
        $loginCount=$checkLogin->fetchColumn();
        if ($loginCount==1)
        {
            return true;
        }
        else
        {
            array_push($this->errorArray, "Your username or password is invalid");
            return false;
        }
    }

}
?>