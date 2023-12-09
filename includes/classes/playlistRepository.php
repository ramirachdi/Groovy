<?php


include_once("includes/autoload.php");
class playlistRepository
{
    protected PDO $con;
    public function __construct()
    {
        $this->con=ConnexionBD::getInstance();
    }
    public function findAllByUsername($username)
    {
        $playlistsQuery = "SELECT * FROM playlists WHERE owner=?";
        $playlistResponse=$this->con->prepare($playlistsQuery);
        $playlistResponse->execute([$username]);
        return $playlistResponse->fetchAll(PDO::FETCH_ASSOC);

    }
    public function findById($id)
    {
        $playlistsQuery = "SELECT * FROM playlists WHERE id=?";
        $playlistResponse=$this->con->prepare($playlistsQuery);
        $playlistResponse->execute([$id]);
        return $playlistResponse->fetch(PDO::FETCH_ASSOC);

    }
    public function findNumberOfSongs($id)
    {
        $playlistsQuery = "SELECT count(*) FROM playlists WHERE id=?";
        $playlistResponse=$this->con->prepare($playlistsQuery);
        $playlistResponse->execute([$id]);
        return $playlistResponse->fetch(PDO::FETCH_COLUMN);
    }

}