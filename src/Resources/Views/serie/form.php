<?php
    if(!isset($edit)){
?>
    <div class="col-12 col-md-12 form-group my-2 position-relative text-center">
        <label for="banner">
            <img src="<?= URL_SITE ?>/public/img/conteudos/banners/series/<?= (!isset($serie->banner) || $serie->banner == "default.png" || $serie->banner == "") ? "default.png" : $serie->banner ?>" alt="Banner" id="banner-preview" class="mx-auto hover-border banner-preview">
        </label>
        <input type="file" name="banner" id="banner" class="d-none">

        <label for="imagem">
            <img src="<?= URL_SITE ?>/public/img/conteudos/capas/series/<?= (!isset($serie->imagem) || $serie->imagem == "default.png" || $serie->imagem == "") ? "default.png" : $serie->imagem ?>" alt="Banner" id="capa-preview" class="mx-auto hover-border capa-preview">
        </label>
        <input type="file" name="imagem" id="imagem" class="d-none">
    </div>
<?php
    }
?>

<?php
    if(!isset($edit_image)){
        if(isset($serie)){
?>
        <div>
            <h3 class="text-muted py-3"><i class="bi-camera-reels-fill"></i> <?= $serie->nome ?></h3>
        </div>

        <div class="col-12 form-group my-2">
            <label for="ativo">Situação</label>
            <select name="ativo" id="ativo" class="form-select">
                <option value="" <?= (isset($serie) && $serie->ativo == "") ? 'selected' : "" ?> >Selecione situação</option>
                <option value=1 <?= (isset($serie) && $serie->ativo == 1) ? 'selected' : "" ?>>Ativo</option>
                <option value=0 <?= (isset($serie) && $serie->ativo == 0) ? 'selected' : "" ?>>Inativo</option>
            </select>
        </div>
    <?php
        }
    ?>

    <div class="col-12 col-md-12 form-group my-2">
        <label for="nome">Nome da série</label>
        <input type="text" name="nome" id="nome" class="form-control py-2" placeholder="Insira o nome" value="<?= $serie->nome ?? '' ?>">
    </div>

    <div class="col-12 col-md-12 form-group my-2">
        <label for="descricao">Descrição</label>
        <textarea rows="5" name="descricao" id="descricao" class="form-control py-2" placeholder="Descrição/prólogo do filme"><?= $serie->descricao ?? '' ?></textarea>
    </div>

<?php
    }
?>
