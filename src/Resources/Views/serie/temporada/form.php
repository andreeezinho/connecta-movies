<div>
    <h3 class="text-muted py-3"><i class="bi-camera-reels-fill"></i> <?= $serie->nome ?></h3>
</div>

<div class="col-12 col-md-12 form-group my-2">
    <label for="numero">Nº da Temporada</label>
    <input type="number" name="numero" id="numero" class="form-control py-2" placeholder="Insira o numero" value="<?= $temporada->numero ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="ativo">Situação</label>
    <select name="ativo" id="ativo" class="form-select">
        <option value="" <?= (isset($temporada) && $temporada->ativo == "") ? 'selected' : "" ?> >Selecione situação</option>
        <option value=1 <?= (isset($temporada) && $temporada->ativo == 1) ? 'selected' : "" ?>>Ativo</option>
        <option value=0 <?= (isset($temporada) && $temporada->ativo == 0) ? 'selected' : "" ?>>Inativo</option>
    </select>
</div>

