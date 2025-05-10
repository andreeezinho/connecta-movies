<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Config\Auth;
use App\Interfaces\User\IUser;
use App\Repositories\User\UserRepository;
use App\Interfaces\Filme\IFilme;
use App\Repositories\Filme\FilmeRepository;
use App\Interfaces\Serie\ISerie;
use App\Repositories\Serie\SerieRepository;

class DashboardController extends Controller {

    protected $auth;
    protected $userRepository;
    protected $filmeRepository;
    protected $serieRepository;

    public function __construct(IUser $userRepository, IFilme $filmeRepository, ISerie $serieRepository){
        parent::__construct();
        $this->auth = new Auth();
        $this->userRepository = $userRepository;
        $this->filmeRepository = $filmeRepository;
        $this->serieRepository = $serieRepository;
    }

    public function index(){
        $user = $this->auth->user();

        $usuarios = $this->userRepository->all();
        $filmes = $this->filmeRepository->all();
        $series = $this->serieRepository->all();

        return $this->router->view('dashboard/index', [
            'user' => $user,
            'usuarios' => $usuarios,
            'filmes' => $filmes,
            'series' => $series
        ]);
    }

}