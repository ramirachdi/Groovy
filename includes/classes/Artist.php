<?php
include_once("includes/autoload.php");

class Artist
{
    private $con;
    private $name;
    private $id;
    private $artistRepo;

    /**
     * @param $con
     * @param $name
     * @param $id
     */
    public function __construct($id)
    {
        $this->con = ConnexionBD::getInstance();
        $this->id = $id;
        $this->artistRepo=new ArtistRepository();
        $artist=$this->artistRepo->findById($this->id);
        $this->artworkPath = $artist->artworkPath;
    }

    public function getName()
    {
        $artist=$this->artistRepo->findById($this->id);
        return $artist->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSongIds()
    {
        $songIdArray=$this->artistRepo->getSongIds($this->id);
        return $songIdArray;

    }

    public function getArtworkPath() {
        return $this->artworkPath;
    }

}
