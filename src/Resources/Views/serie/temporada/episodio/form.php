<div>
    <h3 class="text-muted py-3"><i class="bi-camera-reels-fill"></i> <?= $serie->nome ?></h3>
</div>

<?php
    if(!isset($edit)){
?>
    <div class="col-12 col-md-12 form-group my-2">
        <label for="episodio">Insira o arquivo do vídeo</label>
        <input type="file" name="episodio" id="episodio" class="form-control py-2" value="<?= $episodio->path ?? '' ?>">
    </div>
<?php
    }
?>

<div class="col-12 col-md-12 form-group my-2">
    <label for="numero">Nº do episódio</label>
    <input type="number" name="numero" id="numero" class="form-control py-2" placeholder="Insira o numero" value="<?= $episodio->numero ?? '' ?>">
</div>

<div class="col-12 col-md-12 form-group my-2">
        <label for="nome">Nome do episódio</label>
        <input type="text" name="nome" id="nome" class="form-control py-2" placeholder="Insira o nome" value="<?= $episodio->nome ?? '' ?>">
    </div>

    <div class="col-12 col-md-12 form-group my-2">
        <label for="descricao">Descrição</label>
        <textarea rows="5" name="descricao" id="descricao" class="form-control py-2" placeholder="Descrição/prólogo do filme"><?= $episodio->descricao ?? '' ?></textarea>
    </div>

<div class="col-12 form-group my-2">
    <label for="ativo">Situação</label>
    <select name="ativo" id="ativo" class="form-select">
        <option value="" <?= (isset($episodio) && $episodio->ativo == "") ? 'selected' : "" ?> >Selecione situação</option>
        <option value=1 <?= (isset($episodio) && $episodio->ativo == 1) ? 'selected' : "" ?>>Ativo</option>
        <option value=0 <?= (isset($episodio) && $episodio->ativo == 0) ? 'selected' : "" ?>>Inativo</option>
    </select>
</div>

