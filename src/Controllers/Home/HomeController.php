<?php

namespace App\Controllers\Home;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Interfaces\Filme\IFilme;
use App\Interfaces\Serie\ISerie;
use App\Interfaces\Lista\ILista;


class HomeController extends Controller {

    protected $filmeRepository;
    protected $serieRepository;
    protected $listaRepository;
    protected $auth;

    public function __construct(IFilme $filmeRepository, ISerie $serieRepository, ILista $listaRepository, Auth $auth){
        parent::__construct();
        $this->filmeRepository = $filmeRepository;
        $this->serieRepository = $serieRepository;
        $this->listaRepository = $listaRepository;
        $this->auth = $auth;
    }

    public function index(Request $request){
        $random_filmes = $this->filmeRepository->random();
        $random_series = $this->serieRepository->random();
        if($this->auth->user()){
            $lista_filmes = $this->listaRepository->all(['tipo' => 'filmes','ativo' => 1], $this->auth->user()->id);
            $lista_series = $this->listaRepository->all(['tipo' => 'series','ativo' => 1], $this->auth->user()->id);
        }

        $search = $request->getQueryParams();
        
        if(isset($search['nome']) && !is_null($search['nome'])){
            $random_filmes = $this->filmeRepository->all(['nome' => $search['nome'], 'ativo' => 1]);
            $random_series = $this->serieRepository->all(['nome' => $search['nome'], 'ativo' => 1]);
        }

        return $this->router->view('home/index', [
            'random_filmes' => $random_filmes,
            'random_series' => $random_series,
            'lista_filmes' => $lista_filmes ?? null,
            'lista_series' => $lista_series ?? null,
            'search' => $search
        ]);
    }

}