<?php

namespace App\Controllers\Home;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Filme\FilmeRepository;
use App\Interfaces\Filme\IFilme;

class HomeController extends Controller {

    protected $filmeRepository;
    protected $auth;

    public function __construct(IFilme $filmeRepository, Auth $auth){
        parent::__construct();
        $this->filmeRepository = $filmeRepository;
        $this->auth = $auth;
    }

    public function index(Request $request){
        $filmes = $this->filmeRepository->all(['ativo' => 1]);

        $random_filmes = $this->filmeRepository->randomMovies();

        return $this->router->view('home/index', [
            'filmes' => $filmes,
            'random_filmes' => $random_filmes
        ]);
    }

}