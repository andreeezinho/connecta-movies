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

        $random_filmes = $this->filmeRepository->randomMovies();
        $random_series = $this->serieRepository->randomSeries();

        return $this->router->view('home/index', [
            'random_filmes' => $random_filmes,
            'random_series' => $random_series
        ]);
    }

}