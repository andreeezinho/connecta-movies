<?php

namespace App\Controllers\Filme;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Filme\FilmeRepository;
use App\Interfaces\Filme\IFilme;
use App\Repositories\Lista\ListaRepository;
use App\Interfaces\Lista\ILista;

class FilmeController extends Controller {

    protected $filmeRepository;
    protected $listaRepository;
    protected $auth;

    public function __construct(IFilme $filmeRepository, ListaRepository $listaRepository, Auth $auth){
        parent::__construct();
        $this->filmeRepository = $filmeRepository;
        $this->listaRepository = $listaRepository;
        $this->auth = $auth;
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

        return $this->router->redirect('dashboard/filmes');
    }

    public function edit(Request $request, $uuid){
        $filme = $this->filmeRepository->findByUuid($uuid);

        if(!$filme){
            return $this->router->redirect('404');
        }

        return $this->router->view('filme/edit', [
            'filme' => $filme,
            'edit' => true
        ]);
    }

    public function update(Request $request, $uuid){
        $filme = $this->filmeRepository->findByUuid($uuid);

        if(!$filme){
            return $this->router->redirect('404');
        }

        $data = $request->getBodyParams();
        
        $update = $this->filmeRepository->update($data, $filme->id);

        if(is_null($update)){
            return $this->router->view('filme/edit', [
                'filme' => $filme,
                'erro' => "Erro ao editar o filme"
            ]);
        }

        return $this->router->redirect('dashboard/filmes/'.$filme->uuid.'/editar/imagens');
    }

    public function editImages(Request $request, $uuid){
        $filme = $this->filmeRepository->findByUuid($uuid);

        if(!$filme){
            return $this->router->redirect('404');
        }

        return $this->router->view('filme/edit-image', [
            'filme' => $filme,
            'edit_image' => true
        ]);
    }

    public function updateImages(Request $request, $uuid){
        $filme = $this->filmeRepository->findByUuid($uuid);

        if(!$filme){
            return $this->router->redirect('404');
        }

        $data = $request->getBodyParams();

        if(isset($_FILES['imagem']) && $_FILES['imagem']['name'] != null){
            $data['imagem'] = $_FILES['imagem'];

            $update = $this
                ->filmeRepository
                ->updateImage('imagem', $filme->imagem, $data['imagem'], '/img/conteudos/capas/filmes/', $filme->id);

            if(is_null($update)){
                return $this->router->view('filme/edit-image', [
                    'filme' => $filme,
                    'edit_image' => true,
                    'erro' => 'Erro ao editar imagem da capa'
                ]);
            }
        }

        if(isset($_FILES['banner']) && $_FILES['banner']['name'] != null){
            $data['banner'] = $_FILES['banner'];

            $update = $this
            ->filmeRepository
            ->updateImage('banner', $filme->banner, $data['banner'], '/img/conteudos/banners/filmes/', $filme->id);

            if(is_null($update)){
                return $this->router->view('filme/edit-image', [
                    'filme' => $filme,
                    'edit_image' => true,
                    'erro' => 'Erro ao editar banner'
                ]);
            }
        }

        return $this->router->redirect('dashboard/filmes');
    }

    public function destroy(Request $request, $uuid){
        $filme = $this->filmeRepository->findByUuid($uuid);

        if(!$filme){
            return $this->router->redirect('404');
        }

        $delete = $this->filmeRepository->delete($filme->id);

        if(!$delete){
            return $this->router->view('filme/edit-image', [
                'filme' => $filme,
                'erro' => 'Erro ao deletar o filme'
            ]);
        }

        return $this->router->redirect('dashboard/filmes');
    }

    public function allActiveMovies(Request $request){
        $params = $request->getQueryParams();

        $params = array_merge($params, ['ativo' => 1]);

        $filmes = $this->filmeRepository->all($params);

        return $this->router->view('filme/all-active', [
            'filmes' => $filmes,
            'nome' => $params['nome'] ?? null
        ]);
    }

    public function viewInfosMovie(Request $request, $uuid){
        $user = $this->auth->user();

        $filme = $this->filmeRepository->findByUuid($uuid);

        if(!$filme){
            return $this->router->redirect('404');
        }

        if(!$filme->ativo){
            return $this->router->redirect('404');
        }

        $movieInList = $this->listaRepository->findByUserAndContentId($user->id, $filme->id, 'filmes');
        
        return $this->router->view('filme/view-movie', [
            'filme' => $filme,
            'movieInList' => $movieInList
        ]);
    }

    public function viewMovie(Request $request, $uuid){
        $filme = $this->filmeRepository->findByUuid($uuid);

        if(!$filme){
            return $this->router->redirect('404');
        }

        return $this->router->view('filme/movie', [
            'filme' => $filme
        ]);
    }

}