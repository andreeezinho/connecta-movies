<?php
    require_once __DIR__ . '/../layout/top.php';
?>

<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-6 text-center">
            <h1>Nossos filmes!</h1>
            <p>Por aqui, você pode encontrar o que deseja</p>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-12 col-md-6">
            <form action="/filmes" method="GET" class="d-flex mx-auto">
                <input class="form-control me-2" type="text" name="nome" placeholder="Procure por um filme" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit"><i class="bi-search"></i></button>
                <?php
                    if(isset($nome)){
                ?>
                    <a href="/filmes" class="btn btn-secondary ms-2"><i class="bi-backspace-fill"></i></a>
                <?php
                    }
                ?>
            </form>
        </div>
    </div>

    <div class="row mt-3 g-3 pb-4 border rounded bg-light pb-5">
        <?php
            if(count($filmes) > 0){
                foreach($filmes as $filme){
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
    </div>
</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>