<div class="col-12 col-md-12 form-group my-2">
    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control py-2" placeholder="Insira o nome" value="<?= $colecao->nome ?? '' ?>">
</div>

<div class="col-12 col-md-12 form-group my-2">
    <label for="descricao">Descrição</label>
    <input type="text" name="descricao" id="descricao" class="form-control py-2" placeholder="Insira a descrição" value="<?= $colecao->descricao ?? '' ?>">
</div>

<div class="col-12 form-group my-2">
    <label for="ativo">Situação</label>
    <select name="ativo" id="ativo" class="form-select">
        <option value="" <?= (isset($colecao) && $colecao->ativo == "") ? 'selected' : "" ?> >Selecione situação</option>
        <option value="1" <?= (isset($colecao) && $colecao->ativo == "1") ? 'selected' : "" ?>>Ativo</option>
        <option value="0" <?= (isset($colecao) && $colecao->ativo == "0") ? 'selected' : "" ?>>Inativo</option>
    </select>
</div>

<div class="form-group text-center">
    <a href="/dashboard/colecoes" class="btn btn-secondary mx-1">Cancelar</a>
    <button type="submit" class="btn btn-primary mx-1">Confirmar</button>
</div>