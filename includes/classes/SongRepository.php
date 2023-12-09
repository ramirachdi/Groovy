<?php
class SongRepository
{
    protected PDO $con;
    public function __construct()
    {
        $this->con=ConnexionBD::getInstance();
    }
    public function findByID($id)
    {
        $query="SELECT * from songs where id= ?";
        $resp=$this->con->prepare($query);
        $resp->execute(array($id));
        return $resp->fetch(PDO::FETCH_OBJ);
    }

}