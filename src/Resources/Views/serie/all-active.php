<?php
    require_once __DIR__ . '/../layout/top.php';
?>

<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-6 text-center">
            <h1>Nossas séries!</h1>
            <p>Por aqui, você pode encontrar o que deseja</p>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-12 col-md-6">
            <form action="/series" method="GET" class="d-flex mx-auto">
                <input class="form-control me-2" type="text" name="nome" placeholder="Procure por uma série" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit"><i class="bi-search"></i></button>
                <?php
                    if(isset($nome)){
                ?>
                    <a href="/series" class="btn btn-secondary ms-2"><i class="bi-backspace-fill"></i></a>
                <?php
                    }
                ?>
            </form>
        </div>
    </div>

    <div class="row mt-3 g-3 pb-4 border rounded bg-light">
        <?php
            if(count($series) > 0){
                foreach($series as $serie){
        ?>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="/series/<?= $serie->uuid ?>/infos" class="border-0">
                    <img src="/public/img/conteudos/capas/series/<?= $serie->imagem ?>" class="col-12 col-md-4 col-lg-2 capa hover-border" alt="<?= $serie->nome ?>">
                </a>
            </div>
        <?php
                }
            }else{
        ?>
            <p class="text-muted">Ainda não há séries...</p>
        <?php
            }
        ?>
    </div>
</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>