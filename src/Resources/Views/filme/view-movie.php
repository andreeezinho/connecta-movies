<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= LOGO ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= URL_SITE ?>/public/css/style.css">
    <title><?= SITE_NAME ?></title>
</head>
<body class="bg-theme">
    <img src="/public/img/conteudos/banners/filmes/<?= $filme->banner ?>" alt="Banner" class="banner-container position-relative">

    <a href="/" class="back-link link-light text-decoration-none fw-bold"><i class="bi-chevron-double-left"></i> VOLTAR</a>

    <div class="movie-infos p-4">
        <img src="/public/img/conteudos/capas/filmes/<?= $filme->imagem ?>" alt="Capa" class="capa-info">
        <h1 class="mt-3 text-light"><?= $filme->nome ?></h1>

        <div class="col-12 col-md-6">
            <p class="text-light my-3"><?= $filme->descricao ?></p>
        </div>

        <div class="div col-12 mb-4 d-flex">
            <?php
                if(!$movieInList){
            ?>
                <form action="/filmes/<?= $filme->uuid ?>/favoritar" method="POST">
                    <button type="submit" class="btn text-light p-1 me-3 movie-actions"><i class="bi-bookmark-plus"></i> <p class="p-0 m-0">Minha lista</p></button>
                </form>
            <?php
                }else{
            ?>
                <form action="/filmes/<?= $filme->uuid ?>/desfavoritar" method="POST">
                    <button type="submit" class="btn text-light p-1 me-3 movie-actions"><i class="bi-bookmark-x-fill text-secondary"></i> <p class="p-0 m-0">Remover da lista</p></button>
                </form>
            <?php
                }
            ?>

            <button type="submit" class="btn text-light p-1 me-3 movie-actions"><i class="bi-heart-fill"></i> <p class="p-0 m-0">Avaliar</p></button>
        </div>

        <a href="/filmes/<?= $filme->uuid ?>/assistir" class="btn btn-light py-1 px-5"><i class="bi-play-fill"></i> Assista agora</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="<?= URL_SITE ?>/public/js/script.js"></script>
</body>
</html>
