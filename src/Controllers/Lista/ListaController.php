<?php

namespace App\Controllers\Lista;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Filme\FilmeRepository;
use App\Repositories\Lista\ListaRepository;
use App\Interfaces\Filme\IFilme;
use App\Interfaces\Lista\ILista;

class ListaController extends Controller {

    protected $listaRepository;
    protected $filmeRepository;
    protected $auth;

    public function __construct(ILista $listaRepository, IFilme $filmeRepository, Auth $auth){
        parent::__construct();
        $this->listaRepository = $listaRepository;
        $this->filmeRepository = $filmeRepository;
        $this->auth = $auth;
    }

    public function index(Request $request){
        $user = $this->auth->user();
        
        $params = $request->getQueryParams();
        
        $params = array_merge($params, ['tipo' => 'filmes','ativo' => 1]);

        $lista_filmes = $this->listaRepository->all($params, $user->id);

        return $this->router->view('lista/index', [
            'filmes' => $lista_filmes,
            'nome' => $params['nome'] ?? null
        ]);
    }

    public function addMovieInList(Request $request, $uuid){
        $user = $this->auth->user();

        $filme = $this->filmeRepository->findByUuid($uuid);

        if(!$filme){
            return $this->router->redirect('404');
        }
        
        $data = ['tipo' => 'filmes'];

        $add = $this->listaRepository->create($data, $filme->id, $user->id);

        if(is_null($add)){
            return $this->router->redirect('404');
        }

        return $this->router->redirect('filmes/'. $uuid.'/infos');
    }

    public function removeMovieFromList(Request $request, $uuid){
        $user = $this->auth->user();

        $filme = $this->filmeRepository->findByUuid($uuid);

        if(!$filme){
            return $this->router->redirect('404');
        }     

        $delete = $this->listaRepository->delete($filme->id, $user->id, 'filmes');

        if(!$delete){
            return $this->router->redirect('404');
        }

        return $this->router->redirect('filmes/'. $uuid.'/infos');
    }

}