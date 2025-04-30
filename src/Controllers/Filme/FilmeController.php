<?php

namespace App\Controllers\Filme;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Filme\FilmeRepository;
use App\Interfaces\Filme\IFilme;

class FilmeController extends Controller {

    protected $filmeRepository;

    public function __construct(IFilme $filmeRepository){
        parent::__construct();
        $this->filmeRepository = $filmeRepository;
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $filmes = $this->filmeRepository->all($params);

        return $this->router->view('filme/index', [
            'filmes' => $filmes
        ]);
    }

    public function create(Request $request){
        return $this->router->view('filme/create', []);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        if(isset($_FILES['imagem'])){
            $data['imagem'] = $_FILES['imagem'];
        }

        if(isset($_FILES['banner'])){
            $data['banner'] = $_FILES['banner'];
        }

        if(isset($_FILES['filme'])){
            $data['filme'] = $_FILES['filme'];
        }
        
        $create = $this->filmeRepository->create($data);

        if(is_null($create)){
            return $this->router->view('filme/create', [
                'erro' => 'Erro ao enviar o filme'
            ]);
        }

        return $this->router->redirect('filmes');
    }

}