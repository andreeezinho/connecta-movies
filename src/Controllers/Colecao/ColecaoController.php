<?php

namespace App\Controllers\Colecao;

use App\Request\Request;
use App\Controllers\Controller;
use App\Interfaces\Colecao\IColecao;
use App\Interfaces\Colecao\IColecaoFilme;
use App\Interfaces\Filme\IFilme;

class ColecaoController extends Controller {

    protected $colecaoRepository;
    protected $colecaoFilmeRepository;
    protected $filmeRepository;

    public function __construct(IColecao $colecaoRepository, IColecaoFilme $colecaoFilmeRepository, IFilme $filmeRepository){
        parent::__construct();
        $this->colecaoRepository = $colecaoRepository;
        $this->colecaoFilmeRepository = $colecaoFilmeRepository;
        $this->filmeRepository = $filmeRepository;
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $colecoes = $this->colecaoRepository->all($params);

        return $this->router->view('colecao/index', [
            'colecoes' => $colecoes
        ]);
    }

    public function create(Request $request){
        return $this->router->view('colecao/create');
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        $create = $this->colecaoRepository->create($data);
        
        if(is_null($create)){
            return $this->router->view('colecao/create', [
                'erro' => 'Erro ao cadastrar coleção'
            ]);
        }

        return $this->router->redirect('dashboard/colecoes');
    }

    public function edit(Request $request, $uuid){
        $colecao = $this->colecaoRepository->findByUuid($uuid);

        if(!$colecao){
            return $this->router->redirect('404');
        }

        return $this->router->view('colecao/edit', [
            'colecao' => $colecao
        ]);
    }

    public function update(Request $request, $uuid){
        $colecao = $this->colecaoRepository->findByUuid($uuid);

        if(!$colecao){
            return $this->router->redirect('404');
        }

        $data = $request->getBodyParams();

        $update = $this->colecaoRepository->update($data, $colecao->id);

        if(is_null($update)){
            return $this->router->view('colecao/edit', [
                'colecao' => $colecao,
                'erro' => 'Erro ao editar a coleção'
            ]);
        }

        return $this->router->redirect('dashboard/colecoes');
    }

    public function destroy(Request $request, $uuid){
        $colecao = $this->colecaoRepository->findByUuid($uuid);
        
        if(!$colecao){
            return $this->router->redirect('404');
        }

        $delete = $this->colecaoRepository->delete($colecao->id);

        if(!$delete){
            return $this->router->redirect('404');
        }

        return $this->router->redirect('dashboard/colecoes');
    }

    public function moviesInCollection(Request $request, $uuid){
        $params = $request->getQueryParams();

        $colecao = $this->colecaoRepository->findByUuid($uuid);
        
        if(!$colecao){
            return $this->router->redirect('404');
        }

        $movies = $this->colecaoFilmeRepository->allMoviesInCollection($colecao->id);

        return $this->router->view('colecao/movies', [
            'colecao' => $colecao,
            'filmes' => $movies,
            'nome_filme' => $params['nome_filme'] ?? null
        ]);
    }

    public function allActiveMovies(Request $request, $uuid){
        $params = $request->getQueryParams();

        $params = array_merge($params, ['ativo' => 1]);

        $colecao = $this->colecaoRepository->findByUuid($uuid);
        
        if(!$colecao){
            return $this->router->redirect('404');
        }

        $movies = $this->filmeRepository->all($params);

        return $this->router->view('colecao/active-movies', [
            'colecao' => $colecao,
            'filmes' => $movies,
            'nome' => $params['nome'] ?? null
        ]);
    }


    public function insertInCollection(Request $request, $uuid, $movie_uuid){
        $colecao = $this->colecaoRepository->findByUuid($uuid);
        
        if(!$colecao){
            return $this->router->redirect('404');
        }

        $filme = $this->filmeRepository->findByUuid($movie_uuid);
        
        if(!$filme){
            return $this->router->redirect('404');
        }

        $insert = $this->colecaoFilmeRepository->insertMovieInCollection($colecao->id, $filme->id);
        
        if(is_null($insert)){
            return $this->router->redirect('404?erro=Erro');
        }

        return $this->router->redirect('dashboard/colecoes/'.$colecao->uuid.'/filmes');
    }

    public function removeOfCollection(Request $request, $uuid, $movie_uuid){
        $colecao = $this->colecaoRepository->findByUuid($uuid);
        
        if(!$colecao){
            return $this->router->redirect('404');
        }

        $filme = $this->filmeRepository->findByUuid($movie_uuid);
        
        if(!$filme){
            return $this->router->redirect('404');
        }

        $delete = $this->colecaoFilmeRepository->removeMovieOfCollection($colecao->id, $filme->id);

        if(!$delete){
            return $this->router->redirect('404?teste=teste');
        }

        return $this->router->redirect('dashboard/colecoes/'.$colecao->uuid.'/filmes');

    }

}