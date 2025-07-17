<?php
    require_once __DIR__ . '/../../../layout/top.php';
?>

    <div class="container pb-5">
        <div class="row gx-3 mb-5 border-bottom">
            <div class="col-12">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item">
                        <i class="icon-house_siding lh-1"></i>
                        <a href="/dashboard" class="text-decoration-none text-muted"><i class="bi-house"></i> Home</a>
                    </li>

                    <li class="breadcrumb-item">
                        <i class="icon-house_siding lh-1"></i>
                        <a href="/dashboard/series" class="text-decoration-none text-muted"><?= $serie->nome ?></a>
                    </li>

                    <li class="breadcrumb-item">
                        <i class="icon-house_siding lh-1"></i>
                        <a href="/dashboard/series/<?= $serie->uuid ?>/temporadas" class="text-decoration-none text-muted">Temporadas</a>
                    </li>

                    <li class="breadcrumb-item">
                        <i class="icon-house_siding lh-1"></i>
                        <a href="/dashboard/series/<?= $serie->uuid ?>/temporadas/<?= $temporada->uuid ?>/episodios" class="text-decoration-none text-muted">Temporada <?= $temporada->numero ?></a>
                    </li>

                    <li class="breadcrumb-item">Cadastro</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <form action="/dashboard/series/<?= $serie->uuid ?>/temporadas/<?= $temporada->uuid ?>/episodios/cadastro" method="POST" class="card col-12 py-2 mt-1" enctype="multipart/form-data">
                <?php
                    if(isset($erro)){
                ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <p class="m-0 p-0"><?= $erro ?></p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    }
                ?>
                <div class="row">
                    <?php 
                        include_once('form.php');
                    ?>
                    <div class="form-group text-center">
                        <a href="/dashboard/series/<?= $serie->uuid ?>/temporadas/<?= $temporada->uuid ?>/episodios" class="btn btn-secondary mx-1">Cancelar</a>
                        <button type="submit" class="btn btn-primary mx-1" data-toggle="modal" data-target="#cadastrar-carrossel" data-backdrop="static" data-keyboard="false">Confirmar</button>

                        <div class="modal fade" id="cadastrar-carrossel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content text-center text-dark pt-4">
                                    <div class="spinner-border mx-auto" role="status">
                                        <span class="sr-only"></span>
                                    </div>
                                    <p>O vídeo está sendo carregado...</p>
                                    <div class="text-center py-3">
                                        <a href="/dashboard/series/<?= $serie->uuid ?>/temporadas/<?= $temporada->uuid ?>/episodios/cadastro" class="btn btn-danger">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php
    require_once __DIR__ . '/../../../layout/bottom.php';
?>