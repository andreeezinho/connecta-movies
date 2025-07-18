<?php

namespace App\Controllers\Episodio;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Interfaces\Episodio\IEpisodio;
use App\Interfaces\Episodio\IAssistido;
use App\Interfaces\Temporada\ITemporada;
use App\Interfaces\Serie\ISerie;

class EpisodioController extends Controller {

    protected $episodioRepository;
    protected $assistidoRepository;
    protected $temporadaRepository;
    protected $serieRepository;
    protected $auth;

    public function __construct(IEpisodio $episodioRepository, IAssistido $assistidoRepository, ITemporada $temporadaRepository, ISerie $serieRepository, Auth $auth){
        parent::__construct();
        $this->episodioRepository = $episodioRepository;
        $this->assistidoRepository = $assistidoRepository;
        $this->temporadaRepository = $temporadaRepository;
        $this->serieRepository = $serieRepository;
        $this->auth = $auth;
    }

    public function index(Request $request, $serie_uuid, $temporada_uuid){
        $serie = $this->serieRepository->findByUuid($serie_uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $temporada = $this->temporadaRepository->findByUuid($temporada_uuid);

        if(!$temporada){
            return $this->router->redirect('404');
        }

        $episodios = $this->episodioRepository->all(['temporadas_id' => $temporada->id]);

        return $this->router->view('serie/temporada/episodio/index', [
            'serie' => $serie,
            'temporada' => $temporada,
            'episodios' => $episodios
        ]);
    }

    public function create(Request $request, $serie_uuid, $temporada_uuid){
        $serie = $this->serieRepository->findByUuid($serie_uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $temporada = $this->temporadaRepository->findByUuid($temporada_uuid);

        if(!$temporada){
            return $this->router->redirect('404');
        }

        return $this->router->view('serie/temporada/episodio/create', [
            'serie' => $serie,
            'temporada' => $temporada
        ]);
    }

    public function store(Request $request, $serie_uuid, $temporada_uuid){
        $serie = $this->serieRepository->findByUuid($serie_uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $temporada = $this->temporadaRepository->findByUuid($temporada_uuid);

        if(!$temporada){
            return $this->router->redirect('404');
        }

        $data = $request->getBodyParams();

        if(isset($_FILES['episodio'])){
            $data['episodio'] = $_FILES['episodio'];
        }

        $create = $this->episodioRepository->create($data, $temporada->id);

        if(is_null($create)){
            return $this->router->view('serie/temporada/episodio/create', [
                'serie' => $serie,
                'temporada' => $temporada,
                'erro' => 'Erro ao criar o episódio'
            ]);
        }

        return $this->router->redirect('dashboard/series/'.$serie->uuid.'/temporadas/'.$temporada->uuid.'/episodios');
    }

    public function edit(Request $request, $serie_uuid, $temporada_uuid, $episodio_uuid){
        $serie = $this->serieRepository->findByUuid($serie_uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $temporada = $this->temporadaRepository->findByUuid($temporada_uuid);

        if(!$temporada){
            return $this->router->redirect('404');
        }

        $episodio = $this->episodioRepository->findByUuid($episodio_uuid);

        if(!$episodio){
            return $this->router->redirect('404');
        }

        return $this->router->view('serie/temporada/episodio/edit', [
            'serie' => $serie,
            'temporada' => $temporada,
            'episodio' => $episodio,
            'edit' => true
        ]);
    }

    public function update(Request $request, $serie_uuid, $temporada_uuid, $episodio_uuid){
        $serie = $this->serieRepository->findByUuid($serie_uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $temporada = $this->temporadaRepository->findByUuid($temporada_uuid);

        if(!$temporada){
            return $this->router->redirect('404');
        }


        $episodio = $this->episodioRepository->findByUuid($episodio_uuid);

        if(!$episodio){
            return $this->router->redirect('404');
        }

        $data = $request->getBodyParams();

        $update = $this->episodioRepository->update($data, $temporada->id, $episodio->id);

        if(is_null($update)){
            return $this->router->view('serie/temporada/episodio/create', [
                'serie' => $serie,
                'temporada' => $temporada,
                'episodio' => $episodio,
                'edit' => true,
                'erro' => 'Erro ao criar o episódio'
            ]);
        }

        return $this->router->redirect('dashboard/series/'.$serie->uuid.'/temporadas'.'/'.$temporada->uuid.'/episodios');
    }

    public function destroy(Request $request, $serie_uuid, $temporada_uuid, $episodio_uuid){
        $serie = $this->serieRepository->findByUuid($serie_uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $temporada = $this->temporadaRepository->findByUuid($temporada_uuid);

        if(!$temporada){
            return $this->router->redirect('404');
        }

        $episodio = $this->episodioRepository->findByUuid($episodio_uuid);

        if(!$episodio){
            return $this->router->redirect('404');
        }

        $delete = $this->episodioRepository->delete($data, $temporada->id, $episodio->id);

        if(!$delete){
            return $this->router->redirect('404');
        }

        return $this->router->redirect('dashboard/series/'.$serie->uuid.'/temporadas/'.$temporada->uuid.'/episodios');
    }

    public function viewEpisode(Request $request, $serie_uuid, $episodio_uuid){
        $serie = $this->serieRepository->findByUuid($serie_uuid);

        if(!$serie){
            return $this->router->redirect('404');
        }

        $episodio = $this->episodioRepository->findByUuid($episodio_uuid);

        if(!$episodio){
            return $this->router->redirect('404');
        }

        $temporada = $this->temporadaRepository->findById($episodio->temporadas_id);

        if(!$temporada){
            return $this->router->redirect('404');
        }

        $user = $this->auth->user();
        
        if(!$this->assistidoRepository->findByUserAndEpisodeId($user->id, $episodio->id)){
            $makeEpisodeWatched = $this->assistidoRepository->create(null, $user->id, $episodio->id);
        }

        $proxEp = $this->episodioRepository->findByNumberAndTempId($episodio->numero + 1, $temporada->id);
        
        if($proxEp){
            $urlProxEp = 'series/' . $serie->uuid . '/' . $proxEp->uuid;
        }

        return $this->router->view('serie/temporada/episodio/episode', [
            'serie' => $serie,
            'temporada' => $temporada,
            'episodio' => $episodio,
            'proxEp' => $urlProxEp ?? null
        ]);
    }

}