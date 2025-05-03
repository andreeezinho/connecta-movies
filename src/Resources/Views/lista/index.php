<?php
    require_once __DIR__ . '/../layout/top.php';
?>

<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-6 text-center">
            <h1>Minha Lista</h1>
            <p>Filmes e séries adicionados à minha lista</p>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-12 col-md-6">
            <form action="/minha-lista" method="GET" class="d-flex mx-auto">
                <input class="form-control me-2" type="text" name="nome" placeholder="Procure por um filme ou série">
                <button class="btn btn-outline-primary" type="submit"><i class="bi-search"></i></button>
                <?php
                    if(isset($nome)){
                ?>
                    <a href="/minha-lista" class="btn btn-secondary ms-2"><i class="bi-backspace-fill"></i></a>
                <?php
                    }
                ?>
            </form>
        </div>
    </div>
    
    <div class="col-12 border-bottom">
        <h1>Filmes</h1>
    </div>
    <div class="row mt-3 g-3 pb-4 mb-5 border rounded bg-light">
        <?php
            if(count($filmes) > 0){
                foreach($filmes as $filme){
        ?>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="/filmes/<?= $filme->filme_uuid ?>/infos" class="border-0">
                    <img src="/public/img/conteudos/capas/filmes/<?= $filme->imagem ?>" class="col-12 col-md-4 col-lg-2 capa hover-border" alt="<?= $filme->nome ?>">
                </a>
            </div>
        <?php
                }
            }else{
        ?>
            <p class="text-muted">Não há filmes na sua lista</p>
        <?php
            }
        ?>
    </div>

    <div class="col-12 border-bottom pt-5">
        <h1>Séries</h1>
    </div>
    <div class="row mt-3 g-3 pb-4 border rounded bg-light">
        <?php
            if(count($filmes) > 0){
                foreach($filmes as $filme){
        ?>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="/filmes/<?= $filme->filme_uuid ?>/infos" class="border-0">
                    <img src="/public/img/conteudos/capas/filmes/<?= $filme->imagem ?>" class="col-12 col-md-4 col-lg-2 capa hover-border" alt="<?= $filme->nome ?>">
                </a>
            </div>
        <?php
                }
            }else{
        ?>
            <p class="text-muted">Não há séries na sua lista</p>
        <?php
            }
        ?>
    </div>
</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>