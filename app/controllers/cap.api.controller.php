<?php

require_once ('./app/models/cap.model.php');
require_once ('./app/views/json.view.php');


class CapApiController {
    private $model;
    private $view;

    public function __construct(){
        $this->model = new CapModel();
        $this->view = new JSONView();
    }

    public function getAll($req, $res){
        $orderBy = false;
        $direc = null;
        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
            if (isset($req->query->direc)) {
                $direc = $req->query->direc;
            }
        }

        $temporada = false;
        if(isset($req->query->temporada)){
            $temporada = $req->query->temporada;
        }
        $caps = $this->model->getCaps($orderBy, $direc, $temporada);
        return $this->view->response($caps);
    }

    public function get($req, $res){
        $id = $req->params->id;

        $cap = $this->model->getCap($id);
        if (!$cap) {
            return $this->view->response("El capitulo con el id=$id no existe", 404);
        }
        return $this->view->response($cap);
    }

    public function add($req, $res) {
        // Obtengo las temporadas para poder comprobar si existe
        $temporadas = $this->model->getSeasons();

        // Compruebo si se insertaron los datos
        if (empty($req->body->titulo) || empty($req->body->descripcion) || empty($req->body->video) || empty($req->body->temporada)) {
            return $this->view->response('Faltan completar datos', 404);
        }

        // Compruebo que existe la temporada que se ingresa
        $existe = false;
        foreach ($temporadas as $temporada) {
            if($temporada->id_temporada == $req->body->temporada){
                $existe = true;
            }
        }
        if (!$existe) {
            return $this->view->response('La temporada no existe', 404);
        }

        $titulo = $req->body->titulo;
        $descripcion = $req->body->descripcion;
        $video = $req->body->video;
        $temporada = $req->body->temporada;

        // Añado el capitulo y lo devuelvo
        $id = $this->model->add($titulo, $descripcion, $video, $temporada);

        if (!$id) {
            return $this->view->response('Error al agregar capitulo', 500);
        }
        $cap = $this->model->getCap($id);
        return $this->view->response($cap, 201);
    }

    public function update($req, $res) {
        $id = $req->params->id;

        // Obtengo las temporadas para poder comprobar si existe
        $temporadas = $this->model->getSeasons();

        // Compruebo que exista el capitulo
        $cap = $this->model->getCap($id);
        if (!$cap) {
            return $this->view->response("El capitulo con el id=$id no existe", 404);
        }

         // Valido la entrada de datos
         if (empty($req->body->titulo) || empty($req->body->descripcion) || empty($req->body->video) || empty($req->body->temporada)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // Compruebo que existe la temporada que se ingresa
        $existe = false;
        foreach ($temporadas as $temporada) {
            if($temporada->id_temporada == $req->body->temporada){
                $existe = true;
            }
        }
        if (!$existe) {
            return $this->view->response('La temporada no existe', 404);
        }

        $titulo = $req->body->titulo;       
        $descripcion = $req->body->descripcion;       
        $video = $req->body->video;
        $temporada = $req->body->temporada;

        // Actualizo el capitulo 
        $this->model->update($id, $titulo, $descripcion, $video, $temporada);

        // Obtengo el capitulo y lo devuelvo
        $cap = $this->model->getCap($id);
        $this->view->response($cap, 200);
    }

}

    
