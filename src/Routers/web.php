<?php

use App\Config\Router;
use App\Config\Auth;
use App\Config\Admin;
use App\Config\Container;
use App\Config\DependencyProvider;
use App\Controllers\User\UserController;
use App\Controllers\NotFound\NotFoundController;
use App\Controllers\Home\HomeController;
use App\Controllers\Dashboard\DashboardController;
use App\Controllers\Permissao\PermissaoController;
use App\Controllers\Permissao\PermissaoUserController;
use App\Controllers\User\UserPerfilController;
use App\Controllers\Filme\FilmeController;
use App\Controllers\Lista\ListaController;
use App\Controllers\Serie\SerieController;
use App\Controllers\Temporada\TemporadaController;
use App\Controllers\Episodio\EpisodioController;


$router = new Router();
$auth = new Auth();
$admin = new Admin();
$container = new Container();
$dependencyProvider = new DependencyProvider($container);
$dependencyProvider->register();

//containers creation 
$notFoundController = $container->get(NotFoundController::class);
$userController = $container->get(UserController::class);
$dashboardController = $container->get(DashboardController::class);
$homeController = $container->get(HomeController::class);
$permissaoController = $container->get(PermissaoController::class);
$permissaoUserController = $container->get(PermissaoUserController::class);
$userPerfilController = $container->get(UserPerfilController::class);
$filmeController = $container->get(FilmeController::class);
$listaController = $container->get(ListaController::class);
$serieController = $container->get(SerieController::class);
$temporadaController = $container->get(TemporadaController::class);
$episodioController = $container->get(EpisodioController::class);

//rotas

//not-found
$router->create("GET", "/404", [$notFoundController, 'index']);

//home
$router->create("GET", "/", [$homeController, 'index']);

//login e logout
$router->create("GET", "/login", [$userController, 'login'], null);
$router->create("POST", "/login", [$userController, 'auth'], null);
$router->create("GET", "/logout", [$userController, 'logout'], $auth);

//dashboard
$router->create("GET", "/dashboard", [$dashboardController, 'index'], $auth, $admin);

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
$router->create("GET", "/dashboard/filmes", [$filmeController, 'index'], $auth, $admin);
$router->create("GET", "/dashboard/filmes/cadastro", [$filmeController, 'create'], $auth, $admin);
$router->create("POST", "/dashboard/filmes/cadastro", [$filmeController, 'store'], $auth, $admin);
$router->create("GET", "/dashboard/filmes/{uuid}/editar", [$filmeController, 'edit'], $auth, $admin);
$router->create("POST", "/dashboard/filmes/{uuid}/editar", [$filmeController, 'update'], $auth, $admin);
$router->create("GET", "/dashboard/filmes/{uuid}/editar/imagens", [$filmeController, 'editImages'], $auth, $admin);
$router->create("POST", "/dashboard/filmes/{uuid}/editar/imagens", [$filmeController, 'updateImages'], $auth, $admin);
$router->create("POST", "/dashboard/filmes/{uuid}/deletar", [$filmeController, 'destroy'], $auth, $admin);
$router->create("GET", "/filmes", [$filmeController, 'allActiveMovies'], null);
$router->create("GET", "/filmes/{uuid}/infos", [$filmeController, 'viewInfosMovie'], $auth);
$router->create("GET", "/filmes/{uuid}/assistir", [$filmeController, 'viewMovie'], $auth);

//lista-filme
$router->create("GET", "/minha-lista", [$listaController, 'index'], $auth);
$router->create("POST", "/filmes/{uuid}/favoritar", [$listaController, 'addMovieInList'], $auth);
$router->create("POST", "/filmes/{uuid}/desfavoritar", [$listaController, 'removeMovieFromList'], $auth);
$router->create("POST", "/series/{uuid}/favoritar", [$listaController, 'addSerieInList'], $auth);
$router->create("POST", "/series/{uuid}/desfavoritar", [$listaController, 'removeSerieFromList'], $auth);


//series
$router->create("GET", "/dashboard/series", [$serieController, 'index'], $auth, $admin);
$router->create("GET", "/dashboard/series/cadastro", [$serieController, 'create'], $auth, $admin);
$router->create("POST", "/dashboard/series/cadastro", [$serieController, 'store'], $auth, $admin);
$router->create("GET", "/dashboard/series/{uuid}/editar", [$serieController, 'edit'], $auth, $admin);
$router->create("POST", "/dashboard/series/{uuid}/editar", [$serieController, 'update'], $auth, $admin);
$router->create("GET", "/dashboard/series/{uuid}/editar/imagens", [$serieController, 'editImages'], $auth, $admin);
$router->create("POST", "/dashboard/series/{uuid}/editar/imagens", [$serieController, 'updateImages'], $auth, $admin);
$router->create("POST", "/dashboard/series/{uuid}/deletar", [$serieController, 'destroy'], $auth, $admin);
$router->create("GET", "/series", [$serieController, 'allActiveSeries'], null);
$router->create("GET", "/series/{uuid}/infos", [$serieController, 'viewInfosSerie'], $auth);

//temporada
$router->create("GET", "/dashboard/series/{uuid}/temporadas", [$temporadaController, 'index'], $auth, $admin);
$router->create("GET", "/dashboard/series/{uuid}/temporadas/cadastro", [$temporadaController, 'create'], $auth, $admin);
$router->create("POST", "/dashboard/series/{uuid}/temporadas/cadastro", [$temporadaController, 'store'], $auth, $admin);
$router->create("GET", "/dashboard/series/{uuid}/temporadas/{temporada_uuid}/editar", [$temporadaController, 'edit'], $auth, $admin);
$router->create("POST", "/dashboard/series/{uuid}/temporadas/{temporada_uuid}/editar", [$temporadaController, 'update'], $auth, $admin);
$router->create("POST", "/dashboard/series/{uuid}/temporadas/{temporada_uuid}/deletar", [$temporadaController, 'destroy'], $auth, $admin);

//episodios
$router->create("GET", "/dashboard/series/{uuid}/temporadas/{temporada_uuid}/episodios", [$episodioController, 'index'], $auth, $admin);
$router->create("GET", "/dashboard/series/{uuid}/temporadas/{temporada_uuid}/episodios/cadastro", [$episodioController, 'create'], $auth, $admin);
$router->create("POST", "/dashboard/series/{uuid}/temporadas/{temporada_uuid}/episodios/cadastro", [$episodioController, 'store'], $auth, $admin);
$router->create("GET", "/dashboard/series/{uuid}/temporadas/{temporada_uuid}/episodios/{episodio_uuid}/editar", [$episodioController, 'edit'], $auth, $admin);
$router->create("POST", "/dashboard/series/{uuid}/temporadas/{temporada_uuid}/episodios/{episodio_uuid}/editar", [$episodioController, 'update'], $auth, $admin);
$router->create("POST", "/dashboard/series/{uuid}/temporadas/{temporada_uuid}/episodios/{episodio_uuid}/deletar", [$episodioController, 'destroy'], $auth, $admin);
$router->create("GET", "/series/{uuid}/{uuid_episodio}", [$episodioController, 'viewEpisode'], $auth);


return $router;