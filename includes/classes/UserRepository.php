<?php

class userRepository
{

    protected $db;

    public function __construct()
    {
        $this->db=ConnexionBD::getInstance();
    }

    /**
     * @return users
     */
    public function findAll()
    {
        $request="select * from users";
        $reponse=$this->db->prepare($request);
        $reponse->execute([]);

        return $reponse->fetchAll(PDO::FETCH_OBJ);
    }


    /**
     * @param id $id
     * @return user
     */
    public function findById($id)
    {
        $request="select * from users where id=?";
        $reponse=$this->db->prepare($request);
        $reponse->execute([$id]);

        return $reponse->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $params
     */
    public function create($params)
    {
        $encryptedPw=md5($params[count($params)-1]);
        unset($params[count($params)-1]);
        $profilePic="Pics/profilePic.png";
        $date=date("Y-m-d");
        $request="insert into users values('',?,?,?,?,'$encryptedPw','$date','$profilePic')";
        $reponse=$this->db->prepare($request);
        $reponse->execute($params);

        return $reponse;
    }

    /**
     * @param $id
     * @param $params
     */
    public function update($column, $value, $username)
    {
        $request = "UPDATE users SET $column= ? WHERE username=? ";
        $reponse = $this->db->prepare($request);
        $reponse->execute([$value,$username]);
    }


    /**
     * @param $id
     */
    public function delete($id)
    {
        $request="delete from users where id=?";
        $reponse=$this->db->prepare($request);
        $reponse->execute([$id]);
    }
    public function findByUsername($username)
    {
        $request="Select * from users where username= ?";
        $response=$this->db->prepare($request);
        $response->execute([$username]);
        return $response->fetch(PDO::FETCH_OBJ);
    }
    public function findByEmail($email,$username)
    {
        $request="Select * from users where email=? AND username!='$username'";
        $response=$this->db->prepare($request);
        $response->execute([$email]);
        return $response->fetch(PDO::FETCH_OBJ);
    }


}

?>