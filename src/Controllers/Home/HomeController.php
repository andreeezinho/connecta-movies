<?php

namespace App\Controllers\Home;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Filme\FilmeRepository;
use App\Interfaces\Filme\IFilme;
use App\Repositories\Serie\SerieRepository;
use App\Interfaces\Serie\ISerie;

class HomeController extends Controller {

    protected $filmeRepository;
    protected $serieRepository;
    protected $auth;

    public function __construct(IFilme $filmeRepository, ISerie $serieRepository, Auth $auth){
        parent::__construct();
        $this->filmeRepository = $filmeRepository;
        $this->serieRepository = $serieRepository;
        $this->auth = $auth;
    }

    public function index(Request $request){

        $random_filmes = $this->filmeRepository->random();
        $random_series = $this->serieRepository->random();

        $search = $request->getQueryParams();
        
        if(isset($search['nome']) && !is_null($search['nome'])){
            $random_filmes = $this->filmeRepository->all(['nome' => $search['nome'], 'ativo' => 1]);
            $random_series = $this->serieRepository->all(['nome' => $search['nome'], 'ativo' => 1]);
        }

        return $this->router->view('home/index', [
            'random_filmes' => $random_filmes,
            'random_series' => $random_series,
            'search' => $search
        ]);
    }

}