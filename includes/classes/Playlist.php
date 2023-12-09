<?php
class Playlist {
    private $playlistRepo;
    private $con;
    private $id;
    private $name;
    private $owner;

    public function __construct($data) {
        $this->playlistRepo=new playlistRepository();
        //user only inputs id
        if(!is_array($data)) {
            $data=$this->playlistRepo->findById($data);
        }
        $this->con = ConnexionBD::getInstance();
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->owner = $data['owner'];

    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getOwner() {
        return $this->owner;
    }
    public function getNumberOfSongs() {
        return $this->playlistRepo->findNumberOfSongs($this->id);
    }
    public function getSongIds() {
        $query = "SELECT songId FROM playlistSongs WHERE playlistId = ? ORDER BY playlistOrder ASC";
        $response = $this->con->prepare($query);
        $response->execute([$this->id]);
        $rows = $response->fetchAll(PDO::FETCH_ASSOC);
        $songIds = array();
        foreach ($rows as $row) {
            $songIds[] = $row['songId'];
        }
        return $songIds;
    }
    // con is passed in params because the function is static
    public static function getPlaylistDropdown($con,$username)
    {
        $dropdown=" <select class='item Playlist'>
                        <option value=''>Add To Playlist</option>";
        $query="SELECT id,name FROM playlists where owner=?";
        $resp=$con->prepare($query);
        $resp->execute([$username]);
        $playlists=$resp->fetchAll(PDO::FETCH_OBJ);
        foreach($playlists as $playlist)
        {
            $id=$playlist->id;
            $name=$playlist->name;
            $dropdown.="<option value='$id'>".$name."</option>";
        }
        return $dropdown ."</select>";


        return $dropdown;

    }

}
?>