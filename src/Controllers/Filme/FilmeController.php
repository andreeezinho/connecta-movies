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

}