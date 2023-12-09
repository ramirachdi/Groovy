<?php
include_once("includes/autoload.php");
class ArtistRepository
{
    protected PDO $con;
    public function __construct()
    {
        $this->con=ConnexionBD::getInstance();
    }
    public function findById($id)
    {
        $artistQuery=$this->con->prepare('Select * from artists where id= ?');
        $artistQuery->execute(array($id));
        $artist=$artistQuery->fetch(PDO::FETCH_OBJ);
        return $artist;
    }
    public function getName($id){
        $artistQuery=$this->con->prepare('Select name from artists where id= ?');
        $artistQuery->execute(array($id));
        $artist=$artistQuery->fetch(PDO::FETCH_OBJ);
        return $artist->name;
    }
    public function getSongIds($id){
        $query = $this->con->prepare("SELECT id FROM songs WHERE artist=? ORDER BY plays ASC");
        $query->execute(array($id));
        $array = array();
        while($row = $query->fetch(PDO::FETCH_OBJ)) {
            array_push($array, $row->id);
        }
        return $array;
    }

}
