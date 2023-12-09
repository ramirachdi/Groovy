<?php
include_once "includes/autoload.php";
class User
{
    private $con;
    private $username;
    private $userRepo;
    private $id;
    /**
     * @param $username
     */
    public function __construct($username)
    {
        $this->con=ConnexionBD::getInstance();
        $this->username=$username;
        $this->userRepo=new userRepository();
        $this->id=$this->userRepo->findByUsername($username)->id;
    }
    public function getUsername()
    {
            return $this->username;
    }
    public function getFirstAndLastName()
    {
        return $this->userRepo->findByUsername($this->username)->firstName.' '.$this->userRepo->findById($this->id)->lastName;
    }
    public function getEmail()
    {
        return $this->userRepo->findByUsername($this->username)->email;
    }

}
