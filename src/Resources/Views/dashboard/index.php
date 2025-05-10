<?php
    require_once __DIR__ . '/../layout/top.php';
?>

<div class="container">
    <div class="row">
        <div class="text-muted border-bottom d-flex">
            <p class="m-0 p-0 me-3 mb-2">
                <img src="<?= URL_SITE ?>/public/img/user/icons/<?= $_SESSION['user']->icone ?>" alt="Icone" class="user-icone rounded-circle me-2">
                Olá, <?= explode(' ', trim($user->nome))[0] ?>
            </p>
        </div>
    </div>

    <div class="row mt-3 g-3">
        <h3>Dashboard</h3>

        <div class="col-6 col-md-4">
            <a href='/usuarios' class="card bg-primary text-light text-decoration-none">
                <div class="card-body py-3">
                    <div class='d-flex'>
                        <h3><i class="bi-person-lines-fill"></i></h3>
                        <p class="my-auto ms-2">Usuários</p>
                    </div>
                    <?php
                        if(isset($usuarios) && count($usuarios) > 0){
                    ?>
                        <h3 class="my-2"><?= count($usuarios) ?> </h3>
                    <?php
                        }else{
                    ?>
                        <h3 class="my-2">0</h3>
                    <?php
                        }
                    ?>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href='/dashboard/filmes' class="card bg-primary text-light text-decoration-none">
                <div class="card-body py-3">
                    <div class='d-flex'>
                        <h3><i class="bi-camera-reels-fill"></i></h3>
                        <p class="my-auto ms-2">Filmes</p>
                    </div>
                    <?php
                        if(isset($filmes) && count($filmes) > 0){
                    ?>
                        <h3 class="my-2"><?= count($filmes) ?> </h3>
                    <?php
                        }else{
                    ?>
                        <h3 class="my-2">0</h3>
                    <?php
                        }
                    ?>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href='/dashboard/series' class="card bg-primary text-light text-decoration-none">
                <div class="card-body py-3">
                    <div class='d-flex'>
                        <h3><i class="bi-card-list"></i></h3>
                        <p class="my-auto ms-2">Séries</p>
                    </div>
                    <?php
                        if(isset($series)){
                    ?>
                        <h3 class="my-2"><?= count($series) ?> </h3>
                    <?php
                        }else{
                    ?>
                        <h3 class="my-2">0</h3>
                    <?php
                        }
                    ?>
                </div>
            </a>
        </div>

    </div>
</div>

<?php
    require_once __DIR__ . '/../layout/bottom.php';
?>