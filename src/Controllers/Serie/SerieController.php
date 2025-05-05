<?php

namespace App\Controllers\Serie;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Serie\SerieRepository;
use App\Interfaces\Serie\ISerie;
use App\Repositories\Lista\ListaRepository;
use App\Interfaces\Lista\ILista;

class SerieController extends Controller {

    protected $serieRepository;
    protected $listaRepository;
    protected $auth;

    public function __construct(ISerie $serieRepository, ListaRepository $listaRepository, Auth $auth){
        parent::__construct();
        $this->serieRepository = $serieRepository;
        $this->listaRepository = $listaRepository;
        $this->auth = $auth;
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $series = $this->serieRepository->all($params);

        return $this->router->view('serie/index', [
            'series' => $series
        ]);
    }

    public function create(Request $request){
        return $this->router->view('serie/create', []);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        if(isset($_FILES['imagem'])){
            $data['imagem'] = $_FILES['imagem'];
        }

        if(isset($_FILES['banner'])){
            $data['banner'] = $_FILES['banner'];
        }

        $create = $this->serieRepository->create($data);

        if(is_null($create)){
            return $this->router->view('serie/create', [
                'erro' => 'Erro ao cadastrar a série'
            ]);
        }

        return $this->router->redirect('dashboard/series');

    }

}