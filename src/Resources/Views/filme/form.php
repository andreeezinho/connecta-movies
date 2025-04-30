<?php
    if(!isset($edit)){
?>
    <div class="col-12 col-md-12 form-group my-2 position-relative text-center">
        <label for="banner">
            <img src="<?= URL_SITE ?>/public/img/conteudos/banners/filmes/<?= (!isset($filme->banner) || $filme->banner == "default.png" || $filme->banner == "") ? "default.png" : $filme->banner ?>" alt="Banner" id="banner-preview" class="mx-auto hover-border banner-preview">
        </label>
        <input type="file" name="banner" id="banner" class="d-none">

        <label for="imagem">
            <img src="<?= URL_SITE ?>/public/img/conteudos/capas/filmes/<?= (!isset($filme->imagem) || $filme->imagem == "default.png" || $filme->imagem == "") ? "default.png" : $filme->imagem ?>" alt="Banner" id="capa-preview" class="mx-auto hover-border capa-preview">
        </label>
        <input type="file" name="imagem" id="imagem" class="d-none">
    </div>

    <?php
        if(!isset($edit_image)){
    ?>
        <div class="col-12 col-md-12 form-group my-2">
            <label for="filme">Insira o arquivo do vídeo</label>
            <input type="file" name="filme" id="filme" class="form-control py-2" value="<?= $filme->path ?? '' ?>">
        </div>
    <?php
        }
    ?>
<?php
    }
?>

<?php
    if(!isset($edit_image)){
        if(isset($filme)){
?>
        <div>
            <h3 class="text-muted py-3"><i class="bi-camera-reels-fill"></i> <?= $filme->nome ?></h3>
        </div>

        <div class="col-12 form-group my-2">
            <label for="ativo">Situação</label>
            <select name="ativo" id="ativo" class="form-select">
                <option value="" <?= (isset($filme) && $filme->ativo == "") ? 'selected' : "" ?> >Selecione situação</option>
                <option value=1 <?= (isset($filme) && $filme->ativo == 1) ? 'selected' : "" ?>>Ativo</option>
                <option value=0 <?= (isset($filme) && $filme->ativo == 0) ? 'selected' : "" ?>>Inativo</option>
            </select>
        </div>
    <?php
        }
    ?>

    <div class="col-12 col-md-12 form-group my-2">
        <label for="nome">Nome do filme</label>
        <input type="text" name="nome" id="nome" class="form-control py-2" placeholder="Insira seu nome" value="<?= $filme->nome ?? '' ?>">
    </div>

    <div class="col-12 col-md-12 form-group my-2">
        <label for="descricao">Descrição</label>
        <textarea rows="5" name="descricao" id="descricao" class="form-control py-2" placeholder="Descrição/prólogo do filme"><?= $filme->descricao ?? '' ?></textarea>
    </div>

<?php
    }
?>
