<?php
    require_once __DIR__ . '/../layout/top.php';
?>

<div class="container">
    <div class="row gx-3 mb-2">
        <div class="col-8 col-xl-6">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item">
                    <i class="icon-house_siding lh-1"></i>
                    <a href="/dashboard" class="text-decoration-none text-muted"><i class="bi-house"></i> Home</a>
                </li>

                <li class="breadcrumb-item">
                    <i class="icon-house_siding lh-1"></i>
                    <a href="/dashboard/filmes" class="text-decoration-none text-muted">Filmes</a>
                </li>
            </ol>
        </div>

        <div class="col-4 col-xl-6">
            <div class="float-end">
                <a href="/dashboard/filmes/cadastro" class="btn btn-outline-dark"> + <i class="bi-camera-reels"></i></a>
            </div>
        </div>
    </div>

    <!-- filtros -->
    <div class="col-12">
        <button type="button" class="btn btn-light border p-3 me-2" data-toggle="modal" data-target="#filtro-modal">
            <i class="bi-camera-reels"></i>
            Filtrar filmes
        </button>

        <a href="/dashboard/filmes" class="btn btn-secondary">Limpar</a>
    </div>

    <div class="modal fade" id="filtro-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="/dashboard/filmes" method="GET" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Filtrar filmes</h5>
                </div>

                <div class="modal-body">
                    <p class="mt-2 text-muted">Insira as informações para filtrar</p>

                    <div class="col-12 form-group my-2">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control py-2" placeholder="Insira o nome ou email">
                    </div>

                    <div class="col-12 form-group my-2">
                        <label for="ativo">Situação</label>
                        <select name="ativo" id="ativo" class="form-select">
                            <option value="" selected>Selecione situação</option>
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi-search"></i> Pesquisar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3 g-3 pb-4">
        <?php
            if(count($filmes) > 0){
                foreach($filmes as $filme){
        ?>
            <div class="col-6 col-md-4 col-lg-2">
                <div data-toggle="modal" data-target="#filme-<?= $filme->uuid ?>" class="border-0">
                    <img src="/public/img/conteudos/capas/filmes/<?= $filme->imagem ?>" class="col-12 col-md-4 col-lg-2 capa hover-border" alt="<?= $filme->nome ?>">
                </div>

                <div class="modal fade" id="filme-<?= $filme->uuid ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content text-dark py-2">
                            <div class="modal-header text-center">
                                <h5><i class="bi-camera-reels"></i></h5>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted"><?= $filme->nome ?></p>
                                <p class="mt-3 text-muted">
                                    <i class="bi-circle-fill small <?= ($filme->ativo == 1) ? 'text-success' : 'text-danger' ?>"></i>  
                                    <?= ($filme->ativo == 1) ? 'Ativo' : 'Inativo' ?>
                                </p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <div class="">
                                        <a href="/dashboard/filmes/<?= $filme->uuid ?>/editar" class="btn btn-primary"><i class="bi-pencil-fill"></i></a>
                                        <a href="/filmes/<?= $filme->uuid ?>/infos" class="btn btn-dark"><i class="bi-eye-fill"></i></a>
                                        <button data-toggle="modal" data-target="#filme-delete-<?= $filme->uuid ?>" class="btn btn-danger"><i class="bi-trash-fill"></i></button>

                                        <div class="modal fade" id="filme-delete-<?= $filme->uuid ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content text-dark py-5">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle"><i class="bi-camera-reels"></i> Remover filme?</h5>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p class="">Deseja deletar o filme: <b><?= $filme->nome ?></b>?</p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <form action="/dashboard/filmes/<?= $filme->uuid ?>/deletar" method="POST">
                                                                <button type="submit" class="btn btn-danger">Deletar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>
        <?php
                }
            }else{
        ?>
            <p class="text-muted">Ainda não há filmes...</p>
        <?php
            }
        ?>
    </div>
</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>