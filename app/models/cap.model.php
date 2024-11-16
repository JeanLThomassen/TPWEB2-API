<?php

class CapModel{
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=bdd-bajoterra;charset=utf8', 'root', '');
    }

    public function getCaps($orderBy = false, $temporada){
        $sql = "SELECT * FROM capitulos";

        // Compruebo que la temporada sea un número entero y concateno

        if ($temporada) {
            $sql .= " WHERE temporada = $temporada";
        }

        // Compruebo que exista el campo de ordenación y concateno

        if ($orderBy) {
            switch ($orderBy) {
                case 'temporada':
                    $sql .= ' ORDER By temporada';
                    break;
                case 'titulo':
                    $sql .= ' ORDER By titulo';
                    break;
            }
        }

        $query = $this->db->prepare($sql);
        $query->execute();

        $caps = $query->fetchAll(PDO::FETCH_OBJ);
        return $caps;
    }

    public function getCap($id){
        $query = $this->db->prepare('SELECT * FROM capitulos WHERE id = ?');
        $query->execute([$id]);

        $cap = $query->fetchAll(PDO::FETCH_OBJ);
        return $cap;
    }
    public function getCapsXSeason($temporada){
        $query = $this->db->prepare('SELECT * FROM capitulos WHERE temporada = ?');
        $query->execute([$temporada]);

        $caps = $query->fetchAll(PDO::FETCH_OBJ);
        return $caps;
    }

    public function getSeasons(){
        $query = $this->db->prepare('SELECT * FROM temporada');
        $query->execute();

        $seasons = $query->fetchAll(PDO::FETCH_OBJ);
        return $seasons;
    }
    public function add($titulo, $descripcion, $video, $temporada) { 
        $query = $this->db->prepare('INSERT INTO capitulos(titulo, descripcion, video, temporada) VALUES (?, ?, ?, ?)');
        $query->execute([$titulo, $descripcion, $video, $temporada]);
    
        $id = $this->db->lastInsertId();
    
        return $id;
    }

    function update($id, $titulo, $descripcion, $video, $temporada) {    
        $query = $this->db->prepare('UPDATE capitulos SET titulo = ?, descripcion = ?, video = ?, temporada = ? WHERE id = ?');
        $query->execute([$titulo, $descripcion, $video, $temporada, $id]);
    }

}
