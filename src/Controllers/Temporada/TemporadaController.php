<?php

namespace App\Controllers\Temporada;

use App\Request\Request;
use App\Controllers\Controller;
use App\Repositories\Serie\SerieRepository;
use App\Interfaces\Serie\ISerie;
use App\Repositories\Temporada\TemporadaRepository;
use App\Interfaces\Temporada\ITemporada;

class TemporadaController extends Controller {

    protected $serieRepository;
    protected $temporadaRepository;

    public function __construct(ISerie $serieRepository, TemporadaRepository $temporadaRepository){
        parent::__construct();
        $this->serieRepository = $serieRepository;
        $this->temporadaRepository = $temporadaRepository;
    }

    public function index(Request $request, $uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $temporadas = $this->temporadaRepository->all(['series_id' => $serie->id]);

        return $this->router->view('serie/temporada/index', [
            'serie' => $serie,
            'temporadas' => $temporadas
        ]);
    }

    public function create(Request $request, $uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        return $this->router->view('serie/temporada/create', [
            'serie' => $serie
        ]);
    }

    public function store(Request $request, $uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $data = $request->getBodyParams();

        $create = $this->temporadaRepository->create($data, $serie->id);

        if(is_null($create)){
            return $this->router->view('serie/temporada/create', [
                'serie' => $serie,
                'erro' => 'Erro ao criar a temporada'
            ]);
        }

        return $this->router->redirect('dashboard/series/'.$serie->uuid.'/temporadas');
    }

    public function edit(Request $request, $uuid, $temporada_uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $temporada = $this->temporadaRepository->findByUuid($temporada_uuid);

        if(!$temporada){
            return $this->router->redirect('404');
        }

        return $this->router->view('serie/temporada/edit', [
            'serie' => $serie,
            'temporada' => $temporada
        ]);
    }

    public function update(Request $request, $uuid, $temporada_uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $temporada = $this->temporadaRepository->findByUuid($temporada_uuid);

        if(!$temporada){
            return $this->router->redirect('404');
        }

        $data = $request->getBodyParams();

        $update = $this->temporadaRepository->update($data, $serie->id, $temporada->id);

        if(is_null($update)){
            return $this->router->view('serie/temporada/create', [
                'serie' => $serie,
                'temporada' => $temporada,
                'erro' => 'Erro ao criar a temporada'
            ]);
        }

        return $this->router->redirect('dashboard/series/'.$serie->uuid.'/temporadas');
    }

    public function destroy(Request $request, $uuid, $temporada_uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $temporada = $this->temporadaRepository->findByUuid($temporada_uuid);

        if(!$temporada){
            return $this->router->redirect('404');
        }

        $delete = $this->temporadaRepository->delete($temporada->id);
        
        if(!$delete){
            return $this->router->view('404');
        }

        return $this->router->redirect('dashboard/series/'.$serie->uuid.'/temporadas');
    }

}