<?php
class UserModel extends Model{

    public function getByUser($user){
        $query = $this->db->prepare('Select * from usuarios where nombre = ?');
        $query->execute([$user]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}