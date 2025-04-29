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
                    <a href="/filmes" class="text-decoration-none text-muted">Filmes</a>
                </li>
            </ol>
        </div>

        <div class="col-4 col-xl-6">
            <div class="float-end">
                <a href="/filmes/cadastro" class="btn btn-outline-dark"> + <i class="bi-camera-reels"></i></a>
            </div>
        </div>
    </div>

    <!-- filtros -->
    <div class="col-12">
        <div class="row justify-content-center">
            <form action="/filmes" method="GET" class="col-8 d-flex">
                <input class="form-control mr-sm-2 me-2" type="text" name="nome" placeholder="Procure por um filme aqui" aria-label="Search">
                <button class="btn btn-success my-2 my-sm-0" type="submit"><i class="bi-search"></i></button>
            </form>
        </div>

        <a href="/filmes" class="btn btn-secondary">Limpar</a>
    </div>

    <div class="row mt-3 g-3 pb-4">
        <?php
            if(count($filmes) > 0){
                foreach($filmes as $filme){
        ?>
            <div class="col-12 col-md-4 col-lg-2">
                <a href="/filme/<?= $filme->uuid ?>">
                    <img src="/public/img/conteudos/capas/filmes/<?= $filme->imagem ?>" class="col-12 col-md-4 col-lg-2 capa" alt="<?= $filme->nome ?>">
                </a>
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

<form action="/filmes/cadastro" method="POST" enctype="multipart/form-data">
    <input type="text" name="nome" id="nome">
    <textarea name="descricao" id="descricao"></textarea>
    <input type="file" name="imagem" id="imagem">
    <input type="file" name="banner" id="banner">
    <input type="file" name="filme" id="filme">

    <button type="submit">Enviar</button>
</form>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>