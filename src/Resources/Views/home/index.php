<?php
    require_once __DIR__ . '/../layout/top-home.php';
?>

<section>
    <div id="carouselExampleRide" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
                foreach($random_filmes as $index => $filme){
            ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" data-bs-interval="5000">
                    <img src="/public/img/conteudos/banners/filmes/<?= $filme->banner ?>" class="d-block w-100 banner-carousel" alt="Banner">
                    <div class="carousel-caption text-start pb-0 pb-md-5 mb-none">
                        <h1 class="d-none d-md-block"><?= $filme->nome ?></h1>
                        <h5 class="d-block d-md-none"><?= $filme->nome ?></h5>
                        <div class="mt-md-3 pb-md-5">
                            <a href="/filmes/<?= $filme->uuid ?>/infos" class="btn btn-light py-md-1 px-md-5"><i class="bi-play-fill"></i> Assita agora</a>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>

            <?php
                foreach($random_series as $serie){
            ?>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="/public/img/conteudos/banners/series/<?= $serie->banner ?>" class="d-block w-100 banner-carousel" alt="Banner">
                    <div class="carousel-caption text-start pb-0 pb-md-5 mb-none">
                        <h1 class="d-none d-md-block"><?= $serie->nome ?></h1>
                        <h5 class="d-block d-md-none"><?= $serie->nome ?></h5>
                        <div class="mt-md-3 pb-md-5">
                            <a href="/series/<?= $serie->uuid ?>/infos" class="btn btn-light py-md-1 px-md-5"><i class="bi-play-fill"></i> Assita agora</a>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
            
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<section class="vertical-size mt-5 pb-5">
    <div class="container pb-5">
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-6 text-center">
                <img src="<?= LOGO ?>" alt="Logo site" class="col-3 mx-auto mb-5">
                <p>Ache seus filmes e séries para se divertir!</p>
            </div>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-6">
                <form action="/" method="GET" class="d-flex mx-auto">
                    <input class="form-control me-2" type="text" name="nome" placeholder="Procure por um filme ou série" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi-search"></i></button>
                    <?php
                        if(isset($nome)){
                    ?>
                        <a href="/" class="btn btn-secondary ms-2"><i class="bi-backspace-fill"></i></a>
                    <?php
                        }
                    ?>
                </form>
            </div>
        </div>

        <div class="border-bottom">
            <h1>Filmes</h1>
            <p class="text-muted">Alguns filmes para você</p>
        </div>

        <div class="row mt-3 g-3 pb-4 border rounded bg-light">
            <?php
                if(count($random_filmes) > 0){
                    foreach($random_filmes as $filme){
            ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="/filmes/<?= $filme->uuid ?>/infos" class="border-0">
                        <img src="/public/img/conteudos/capas/filmes/<?= $filme->imagem ?>" class="col-12 col-md-4 col-lg-2 capa hover-border" alt="<?= $filme->nome ?>">
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
            
            <div class="justify-content-center text-center">
                <a href="/filmes" class="btn btn-outline-primary py-2 px-4 rounded-pill">Veja mais <i class="bi-arrow-down"></i></a>
            </div>
        </div>

        <div class="border-bottom mt-5">
            <h1>Séries</h1>
            <p class="text-muted">Algumas de nossas séries!</p>
        </div>

        <div class="row mt-3 g-3 pb-4 border rounded bg-light">
            <?php
                if(count($random_series) > 0){
                    foreach($random_series as $series){
            ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="/series/<?= $series->uuid ?>/infos" class="border-0">
                        <img src="/public/img/conteudos/capas/series/<?= $series->imagem ?>" class="col-12 col-md-4 col-lg-2 capa hover-border" alt="<?= $series->nome ?>">
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
            
            <div class="justify-content-center text-center">
                <a href="/series" class="btn btn-outline-primary py-2 px-4 rounded-pill">Veja mais <i class="bi-arrow-down"></i></a>
            </div>
        </div>
    </div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>