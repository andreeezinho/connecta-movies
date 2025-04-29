<?php

use App\Config\Router;
use App\Config\Auth;
use App\Config\Container;
use App\Config\DependencyProvider;
use App\Controllers\User\UserController;
use App\Controllers\NotFound\NotFoundController;
use App\Controllers\Dashboard\DashboardController;
use App\Controllers\Permissao\PermissaoController;
use App\Controllers\Permissao\PermissaoUserController;
use App\Controllers\User\UserPerfilController;
use App\Controllers\Filme\FilmeController;


$router = new Router();
$auth = new Auth();
$container = new Container();
$dependencyProvider = new DependencyProvider($container);
$dependencyProvider->register();

//containers creation 
$notFoundController = $container->get(NotFoundController::class);
$userController = $container->get(UserController::class);
$dashboardController = $container->get(DashboardController::class);
$permissaoController = $container->get(PermissaoController::class);
$permissaoUserController = $container->get(PermissaoUserController::class);
$userPerfilController = $container->get(UserPerfilController::class);
$filmeController = $container->get(FilmeController::class);

//rotas

//not-found
$router->create("GET", "/404", [$notFoundController, 'index']);

//login e logout
$router->create("GET", "/login", [$userController, 'login'], null);
$router->create("POST", "/login", [$userController, 'auth'], null);
$router->create("GET", "/logout", [$userController, 'logout'], $auth);

//dashboard
$router->create("GET", "/dashboard", [$dashboardController, 'index'], $auth);

//usuarios
$router->create("GET", "/usuarios", [$userController, 'index'], $auth);
$router->create("GET", "/usuarios/cadastro", [$userController, 'create'], $auth);
$router->create("POST", "/usuarios/cadastro", [$userController, 'store'], $auth);
$router->create("GET", "/usuarios/{uuid}/editar", [$userController, 'edit'], $auth);
$router->create("POST", "/usuarios/{uuid}/editar", [$userController, 'update'], $auth);
$router->create("POST", "/usuarios/{uuid}/deletar", [$userController, 'destroy'], $auth);

//permissoes
$router->create("GET", "/permissoes", [$permissaoController, 'index'], $auth);
$router->create("GET", "/permissoes/cadastro", [$permissaoController, 'create'], $auth);
$router->create("POST", "/permissoes/cadastro", [$permissaoController, 'store'], $auth);
$router->create("GET", "/permissoes/{uuid}/editar", [$permissaoController, 'edit'], $auth);
$router->create("POST", "/permissoes/{uuid}/editar", [$permissaoController, 'update'], $auth);
$router->create("POST", "/permissoes/{uuid}/deletar", [$permissaoController, 'destroy'], $auth);

//permissao_user
$router->create("GET", "/usuarios/{uuid}/permissoes", [$permissaoUserController, 'index'], $auth);
$router->create("POST", "/usuarios/{uuid}/vincular", [$permissaoUserController, 'create'], $auth);
$router->create("POST", "/usuarios/{usuario_uuid}/desvincular/{permissao_uuid}", [$permissaoUserController, 'destroy'], $auth);

//perfil usuario
$router->create("GET", "/perfil", [$userPerfilController, 'index'], $auth);
$router->create("POST", "/perfil/icone", [$userPerfilController, 'updateIcone'], $auth);
$router->create("POST", "/perfil/editar", [$userPerfilController, 'updateDados'], $auth);
$router->create("POST", "/perfil/senha", [$userPerfilController, 'updateSenha'], $auth);
$router->create("POST", "/perfil/deletar", [$userPerfilController, 'destroy'], $auth);

//filmes
$router->create("GET", "/filmes", [$filmeController, 'index'], $auth);

return $router;