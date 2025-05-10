<?php

namespace App\Controllers\Serie;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Repositories\Serie\SerieRepository;
use App\Interfaces\Serie\ISerie;
use App\Repositories\Lista\ListaRepository;
use App\Interfaces\Lista\ILista;
use App\Repositories\Temporada\TemporadaRepository;
use App\Interfaces\Temporada\ITemporada;
use App\Repositories\Episodio\EpisodioRepository;
use App\Interfaces\Episodio\IEpisodio;

class SerieController extends Controller {

    protected $serieRepository;
    protected $listaRepository;
    protected $temporadaRepository;
    protected $episodioRepository;
    protected $auth;

    public function __construct(ISerie $serieRepository, ListaRepository $listaRepository, ITemporada $temporadaRepository, IEpisodio $episodioRepository, Auth $auth){
        parent::__construct();
        $this->serieRepository = $serieRepository;
        $this->listaRepository = $listaRepository;
        $this->temporadaRepository = $temporadaRepository;
        $this->episodioRepository = $episodioRepository;
        $this->auth = $auth;
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $series = $this->serieRepository->all($params);

        return $this->router->view('serie/index', [
            'series' => $series
        ]);
    }

    public function create(Request $request){
        return $this->router->view('serie/create', []);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        if(isset($_FILES['imagem'])){
            $data['imagem'] = $_FILES['imagem'];
        }

        if(isset($_FILES['banner'])){
            $data['banner'] = $_FILES['banner'];
        }

        $create = $this->serieRepository->create($data);

        if(is_null($create)){
            return $this->router->view('serie/create', [
                'erro' => 'Erro ao cadastrar a série'
            ]);
        }

        return $this->router->redirect('dashboard/series/'.$create->uuid.'/temporadas');
    }

    public function edit(Request $request, $uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        return $this->router->view('serie/edit', [
            'serie' => $serie,
            'edit' => true
        ]);
    }

    public function update(Request $request, $uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $data = $request->getBodyParams();

        $update = $this->serieRepository->update($data, $serie->id);

        if(is_null($update)){
            return $this->router->view('serie/edit', [
                'serie' => $serie,
                'edit' => true,
                'erro' => 'Erro ao editar série'
            ]);
        }

        return $this->router->redirect('dashboard/series/'.$serie->uuid.'/editar/imagens');
    }

    public function editImages(Request $request, $uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        return $this->router->view('serie/edit-image', [
            'serie' => $serie,
            'edit_image' => true
        ]);
    }

    public function updateImages(Request $request, $uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $data = $request->getBodyParams();

        if(isset($_FILES['imagem']) && $_FILES['imagem']['name'] != null){
            $data['imagem'] = $_FILES['imagem'];

            $update = $this
                ->serieRepository
                ->updateImage('imagem', $serie->imagem, $data['imagem'], '/conteudos/capas/series/', $serie->id);

            if(is_null($update)){
                return $this->router->view('serie/edit-image', [
                    'serie' => $serie,
                    'edit_image' => true,
                    'erro' => 'Erro ao editar imagem da capa'
                ]);
            }
        }

        if(isset($_FILES['banner']) && $_FILES['banner']['name'] != null){
            $data['banner'] = $_FILES['banner'];

            $update = $this
            ->serieRepository
            ->updateImage('banner', $serie->banner, $data['banner'], '/conteudos/banners/series/', $serie->id);

            if(is_null($update)){
                return $this->router->view('serie/edit-image', [
                    'serie' => $serie,
                    'edit_image' => true,
                    'erro' => 'Erro ao editar banner'
                ]);
            }
        }

        return $this->router->redirect('dashboard/series');
    }

    public function destroy(Request $request, $uuid){
        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $delete = $this->serieRepository->delete($serie->id);

        if(!$delete){
            return $this->router->redirect('404');
        }

        return $this->router->redirect('dashboard/series');
    }

    public function allActiveSeries(Request $request){
        $params = $request->getQueryParams();

        $params = array_merge($params, ['ativo' => 1]);

        $series = $this->serieRepository->all($params);

        return $this->router->view('serie/all-active', [
            'series' => $series,
            'nome' => $params['nome'] ?? null
        ]);
    }

    public function viewInfosSerie(Request $request, $uuid){
        $user = $this->auth->user();

        $serie = $this->serieRepository->findByUuid($uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $params = $request->getQueryParams();

        $params = array_merge($params, ['ativo' => 1]);

        $serieInList = $this->listaRepository->findByUserAndContentId($user->id, $serie->id, 'series');

        $allActiveSeasons = $this->temporadaRepository->all(['series_id' => $serie->id ,'ativo' => 1]);

        $temporada = $this->temporadaRepository->findByNumberAndSerieId($params['temp'] ?? 1, $serie->id);

        $allEpisodesInSeason = $this->episodioRepository->all(['temporadas_id' => $temporada->id ?? 1, 'ativo' => 1]);
        
        return $this->router->view('serie/view-serie', [
            'serie' => $serie,
            'serieInList' => $serieInList,
            'temporadas' => $allActiveSeasons,
            'season' => $temporada,
            'temp' => $params['temp'] ?? 1,
            'episodios' => $allEpisodesInSeason
        ]);
    }



}