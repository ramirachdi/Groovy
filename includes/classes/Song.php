<?php
include_once "includes/autoload.php";
class Song {

    private $con;
    private $id;
    private $data;
    private $title;
    private $artistId;
    private $albumId;
    private $genre;
    private $duration;
    private $path;

    public function __construct($id) {
        $this->con = ConnexionBD::getInstance();
        $this->id = $id;
        $songRepo=new SongRepository();
        $this->data=$songRepo->findByID($this->id);
        $this->title = $this->data->title;
        $this->artistId = $this->data->artist;
        $this->albumId = $this->data->album;
        $this->genre = $this->data->genre;
        $this->duration = $this->data->duration;
        $this->path = $this->data->path;
    }

    public function getTitle() {
        return $this->title;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getArtist() {
        return new Artist( $this->artistId);
    }

    public function getAlbum() {
        return new Album($this->albumId);
    }

    public function getPath() {
        return $this->path;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getData() {
        return $this->data;
    }

    public function getGenre() {
        return $this->genre;
    }

}
?>