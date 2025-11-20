<?php
require_once 'model.php';
class ModelNoticias extends Model
{
    public function getAll($limit, $offset, $game, $campo, $order)
    {
        $setencia = "Select * from noticia ";
        $arrExec=[];

        if ($game !== null) {
            $setencia .= " where seccion_id = ?";
            $arrExec[] = $game;
        }

        if($campo !== null && $order !== null) { 
            $setencia .= " Order BY $campo $order";
        }

        if ($limit !== null && $limit > 0 && $offset !== null) {
            $setencia .= " Limit $limit Offset $offset";
        }
        
        $query = $this->db->prepare($setencia);
        $query->execute($arrExec);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($id)
    {
        $query = $this->db->prepare('SELECT * FROM noticia WHERE id = ?');
        $query->execute([$id]);
        $noticia = $query->fetch(PDO::FETCH_OBJ);
        return $noticia;
    }

    function getCampos()
    {
        $query = $this->db->prepare("SELECT COLUMN_NAME
                        FROM INFORMATION_SCHEMA.COLUMNS
                        WHERE TABLE_NAME = N'noticia'");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function crearNoticia($titulo, $img, $resumen, $contenido, $seccion_id)
    {
        $query = $this->db->prepare("Insert Into noticia (titulo,img,resumen,contenido,seccion_id) VALUES (?,?,?,?,?)");
        $query->execute([$titulo, $img, $resumen, $contenido, $seccion_id]);
        $last_id = $this->db->lastInsertId();
        return $last_id;
    }

    public function editarNoticia($id, $titulo, $img, $resumen, $contenido, $seccion_id)
    {
        $query = $this->db->prepare('UPDATE noticia SET titulo = ?, img = ?, resumen = ?, contenido = ?, seccion_id = ? WHERE id = ?');
        $exito = $query->execute([$titulo, $img, $resumen, $contenido, $seccion_id, $id]);
        return $exito;
    }

    public function getPaginado($limit, $offset)
    {
        $query = $this->db->prepare("Select * from noticia Limit $limit OFFSET $offset");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
