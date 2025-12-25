<?php

namespace App\Controllers\Colecao;

use App\Request\Request;
use App\Controllers\Controller;
use App\Interfaces\Colecao\IColecao;

class ColecaoController extends Controller {

    protected $colecaoRepository;

    public function __construct(IColecao $colecaoRepository){
        parent::__construct();
        $this->colecaoRepository = $colecaoRepository;
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

}