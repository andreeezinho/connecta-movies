<?php

namespace App\Controllers\User;

use App\Request\Request;
use App\Config\Auth;
use App\Controllers\Controller;
use App\Interfaces\User\IUser;

class UserController extends Controller {

    protected $userRepository;

    public function __construct(IUser $userRepository){
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    public function index(Request $request){
        $params = $request->getQueryParams();

        $usuarios = $this->userRepository->all($params);

        return $this->router->view('user/index', [
            'usuarios' => $usuarios
        ]);
    }

    public function create(Request $request){
        return $this->router->view('user/create', [
            'perfil' => false
        ]);
    }

    public function store(Request $request){
        $data = $request->getBodyParams();

        $data['icone'] = 'default.png';
    
        if($data['nome'] == "" || $data['email'] == ""  || $data['cpf'] == ""){
            return $this->router->view('user/create', [
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $create = $this->userRepository->create($data);

        if(is_null($create)){
            return $this->router->view('user/create', [
                'erro' => 'Não foi possível criar usuário'
            ]);
        }

        return $this->router->redirect('usuarios');
    }

    public function edit(Request $request, $uuid){
        $usuario = $this->userRepository->findByUuid($uuid);

        if(!$usuario){
            return $this->router->redirect('');
        }

        return $this->router->view('user/edit', [
            'perfil' => false,
            'usuario' => $usuario
        ]);
    }

    public function update(Request $request, $uuid){
        $usuario = $this->userRepository->findByUuid($uuid);

        if(!$usuario){
            return $this->router->redirect('');
        }

        $data = $request->getBodyParams();

        if($data['nome'] == "" || $data['email'] == "" || $data['cpf'] == ""){
            return $this->router->view('user/edit', [
                'erro' => 'Campo obrigatório em branco'
            ]);
        }

        $update = $this->userRepository->update($data, $usuario->id);

        if(is_null($update)){
            return $this->router->view('user/index', [
                'erro' => 'Não foi possível editar usuário'
            ]);
        }

        return $this->router->redirect('usuarios');

    }

    public function destroy(Request $request, $uuid){
        $usuario = $this->userRepository->findByUuid($uuid);

        if(!$usuario){
            return $this->router->redirect('usuarios');
        }

        $delete = $this->userRepository->delete($usuario->id);

        if(!$delete){
            return $this->router->view('user/index', [
                'erro' => 'Não foi possível excluir usuário'
            ]);
        }

        return $this->router->redirect('usuarios');
    }

    public function login(){
        $auth = new Auth();

        if($auth->check()){
            return $this->router->redirect('');
        }

        return $this->router->view('login/login', []);
    }

    public function auth(Request $request){
        $data = $request->getBodyParams();

        $user = $this->userRepository->login($data['email'], $data['senha']);

        $auth = new Auth();

        if($auth->login($user)){
            $attempted_uri = $_SESSION['attempted_uri'] ?? null;

            unset($_SESSION['attempted_uri']);

            return $this->router->redirect($attempted_uri ?? 'dashboard');
        }

        return $this->router->view('login/login', [
            'erro' => 'Usuário não encontrado'
        ]);
    }

    public function logout(){
        $auth = new Auth();
        $auth->logout();
        
        return $this->router->redirect('');
    }

}