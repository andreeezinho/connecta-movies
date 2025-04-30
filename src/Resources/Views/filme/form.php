<div class="col-12 col-md-12 form-group my-2 position-relative">
    <label for="banner">
        <img src="<?= URL_SITE ?>/public/img/conteudos/banners/filmes/<?= (!isset($filme->banner) || $filme->banner == "default.png" || $filme->banner == "") ? "default.png" : $filme->banner ?>" alt="Banner" id="banner-preview" class="mx-auto hover-border banner-preview">
    </label>
    <input type="file" name="banner" id="banner" class="d-none">

    <label for="imagem">
        <img src="<?= URL_SITE ?>/public/img/conteudos/capas/filmes/<?= (!isset($filme->imagem) || $filme->imagem == "default.png" || $filme->imagem == "") ? "default.png" : $filme->banner ?>" alt="Banner" id="capa-preview" class="mx-auto hover-border capa-preview">
    </label>
    <input type="file" name="imagem" id="imagem" class="d-none">
</div>

<div class="col-12 col-md-12 form-group my-2">
    <label for="filme">Insira o arquivo do vídeo</label>
    <input type="file" name="filme" id="filme" class="form-control py-2" value="<?= $filme->path ?? '' ?>">
</div>

<div class="col-12 col-md-12 form-group my-2">
    <label for="nome">Nome do filme</label>
    <input type="text" name="nome" id="nome" class="form-control py-2" placeholder="Insira seu nome" value="<?= $filme->nome ?? '' ?>">
</div>

<div class="col-12 col-md-12 form-group my-2">
    <label for="descricao">Descrição</label>
    <textarea rows="5" name="descricao" id="descricao" class="form-control py-2" placeholder="Descrição/prólogo do filme" value="<?= $filme->descricao ?? '' ?>"></textarea>
</div>