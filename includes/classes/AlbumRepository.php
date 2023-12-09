<?php
include_once("includes/classes/ConnexionBD.php");
    class AlbumRepository
    {
        protected PDO $con;
        public function __construct()
        {
            $this->con=ConnexionBD::getInstance();
        }
        public function findById($id)
        {
            $query=$this->con->prepare('SELECT * FROM albums where id= ?');
            $query->execute(array($id));
            $album=$query->fetch(PDO::FETCH_OBJ);
            return $album;
        }
    }
?>