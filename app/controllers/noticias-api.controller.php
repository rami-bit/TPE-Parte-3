<?php
require_once __DIR__ . '/../models/model-noticia.php';
require_once __DIR__ . '/../models/model-secciones.php';
class NoticiaController
{
    private $modelNoticia;
    private $modelSecciones;

    public function __construct()
    {
        $this->modelNoticia = new ModelNoticias();
        $this->modelSecciones = new ModelSecciones();
    }

    function getAll($request, $response)
    {
        $page  = isset($request->query->page) && (is_numeric($request->query->page)) && $request->query->page > 0  ?  $request->query->page  : null;
        $limit = isset($request->query->limit) && (is_numeric($request->query->limit)) ? $request->query->limit : null;
        $offset = ($page && $limit) ? ($page - 1) * $limit : null;
        $game = isset($request->query->game) && (is_numeric($request->query->game)) ? $request->query->game : null;

        if ($limit !== null && $limit <= 0) {
            return $response->json('ERROR: El limite no puede ser menor o igual a 0', 400);
        }

        $hasOrderBy = isset($request->query->orderby);
        $hasOrder = isset($request->query->order);

        //Checo si el campo y el orden estan seteados
        if ($hasOrderBy && $hasOrder) {
            //si son validos
            if ($this->checkParams($request->query->orderby, $request->query->order)) {
                $campo = $request->query->orderby;
                $order = $request->query->order;
            } else {
                return $response->json('Error: parámetros de orden inválidos', 400);
            }
        } else if (($hasOrderBy && !$hasOrder) || (!$hasOrder && $hasOrder)) {
            return $response->json('Debés enviar ambos parámetros: orderby y order', 400);
        } else {
            $campo = null;
            $order = null;
        }

        $noticias = $this->modelNoticia->getAll($limit, $offset, $game, $campo, $order);
        return $response->json($noticias, 200);
    }


    private function checkParams($campo, $order)
    {
        $order = strtolower($order);
        if ($order !== 'asc' && $order !== 'desc') {
            return false;
        }

        $campo = strtolower($campo);
        $campos = $this->modelNoticia->getCampos();
        foreach ($campos as $c) {
            if ($campo === $c->COLUMN_NAME) {
                return true;
            }
        }
        return false;
    }



    function get($request, $response)
    {
        $id = $request->params->id;

        $notica = $this->modelNoticia->get($id);
        if (!$notica) {
            return $response->json("No se encontro la noticia con el id=$id", 404);
        }

        return $response->json($notica, 200);
    }


    function crearNoticia($request, $response)
    {
        if (!(isset($request->body->titulo) && isset($request->body->img) && isset($request->body->resumen) && isset($request->body->contenido) && isset($request->body->seccion_id))) {
            return $response->json('Faltan campos Obligatorios', 400);
        }

        $titulo = $request->body->titulo;
        $img = $request->body->img;
        $resumen = $request->body->resumen;
        $contenido = $request->body->contenido;
        $seccionID = $request->body->seccion_id;

        if (!$this->modelSecciones->getJuego($seccionID)) {
            return $response->json('EL juego no existe ', 404);
        }
        $agregar = $this->modelNoticia->crearNoticia($titulo, $img, $resumen, $contenido, $seccionID);

        if ($agregar) {
            return $response->json('Noticia Creada Correctamente', 201);
        } else {
            return $response->json('Error en crear noticia', 400);
        }
    }

    function editarNoticia($request, $response)
    {
        $id = $request->params->id;
        if (!$this->modelNoticia->get($id)) {
            return $response->json('No existe la noticia', 404);
        }
        if (!(isset($request->body->titulo) && isset($request->body->img) && isset($request->body->resumen) && isset($request->body->contenido) && isset($request->body->seccion_id))) {
            return $response->json('Faltan campos Obligatorios', 400);
        }



        $titulo = $request->body->titulo;
        $img = $request->body->img;
        $resumen = $request->body->resumen;
        $contenido = $request->body->contenido;
        $seccionID = $request->body->seccion_id;


        if (strlen($titulo) > 255 || strlen($resumen) > 200) {
            return $response->json('Titulo o Resumen superan el limite de caracteres', 400);
        }

        if (!$this->modelSecciones->getJuego($seccionID)) {
            return $response->json('No existe el juego', 404);
        }

        $editado = $this->modelNoticia->editarNoticia($id, $titulo, $img, $resumen, $contenido, $seccionID);

        if ($editado) {
            return $response->json('Archivo modificado!', 200);
        } else {
            return $response->json('Error al modificar el archivo', 400);
        }
    }
}
