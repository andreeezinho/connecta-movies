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
            <form action="/filmes/all" method="GET" class="d-flex mx-auto">
                <input class="form-control me-2" type="text" name="nome" placeholder="Procure por um filme" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit"><i class="bi-search"></i></button>
                <?php
                    if(isset($nome)){
                ?>
                    <a href="/filmes/all" class="btn btn-secondary ms-2"><i class="bi-backspace-fill"></i></a>
                <?php
                    }
                ?>
            </form>
        </div>
    </div>

    <div class="modal fade" id="filtro-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="/filmes" method="GET" class="modal-content">
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

    <div class="row mt-3 g-3 pb-4 border rounded bg-light">
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