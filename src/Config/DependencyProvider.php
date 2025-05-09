<?php

namespace App\Config;

use App\Interfaces\User\IUser;
use App\Repositories\User\UserRepository;
use App\Interfaces\Permissao\IPermissao;
use App\Repositories\Permissao\PermissaoRepository;
use App\Interfaces\Permissao\IPermissaoUser;
use App\Repositories\Permissao\PermissaoUserRepository;
use App\Interfaces\Filme\IFilme;
use App\Repositories\Filme\FilmeRepository;
use App\Interfaces\Lista\ILista;
use App\Repositories\Lista\ListaRepository;
use App\Interfaces\Serie\ISerie;
use App\Repositories\Serie\SerieRepository;
use App\Interfaces\Temporada\ITemporada;
use App\Repositories\Temporada\TemporadaRepository;
use App\Interfaces\Episodio\IEpisodio;
use App\Repositories\Episodio\EpisodioRepository;

class DependencyProvider {

    private $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function register(){

        $this->container
            ->set(
                IUser::class,
                new UserRepository()
            );

        $this->container
            ->set(
                IPermissao::class,
                new PermissaoRepository()
            );

        $this->container
            ->set(
                IPermissaoUser::class,
                new PermissaoUserRepository()
            );

        $this->container
            ->set(
                IFilme::class,
                new FilmeRepository()
            );
        
        $this->container
            ->set(
                ILista::class,
                new ListaRepository()
            );

        $this->container
            ->set(
                ISerie::class,
                new SerieRepository()
            );

        $this->container
            ->set(
                ITemporada::class,
                new TemporadaRepository()
            );

        $this->container
            ->set(
                IEpisodio::class,
                new EpisodioRepository()
            );


    }

}