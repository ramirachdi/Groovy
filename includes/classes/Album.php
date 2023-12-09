<?php
include_once("includes/autoload.php");
class Album {

    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artworkPath;
    private $albumRepo;
    public function __construct($id) {
        $this->con = ConnexionBD::getInstance();
        $this->id = $id;
        $this->albumRepo=new AlbumRepository();
        $album=$this->albumRepo->findById($this->id);
        $this->title = $album->title;
        $this->artistId = $album->artist;
        $this->genre = $album->genre;
        $this->artworkPath = $album->artworkPath;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getArtist() {
        return new Artist($this->artistId);
    }

    public function getGenre() {
        return $this->genre;
    }

    public function getArtworkPath() {
        return $this->artworkPath;
    }
    public function getNumberOfSongs()
    {
        $query="Select * from Songs where album = ?";
        $resp=$this->con->prepare($query);
        $resp->execute(array($this->id));
        return $resp->rowCount();
    }
    public function getSongIds()
    {
        $array=array();
        $query="Select * from songs where album=$this->id ORDER BY albumOrder ";
        $resp=$this->con->query($query);
        $songIds=$resp->fetchAll(PDO::FETCH_OBJ);
        foreach($songIds as $Song)
            {
             array_push($array,$Song->id);
            }
        return $array;
    }
    public function getId()
    {
        return $this->id;
    }
}
?>
