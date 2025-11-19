<?php
require_once 'model.php';
class ModelSecciones extends Model {
    
    function getJuego($id) {
        $query = $this->db->prepare('Select * from secciones where id = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

}