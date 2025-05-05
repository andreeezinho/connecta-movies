<?php

namespace App\Models\Serie;

use App\Models\Traits\Uuid;

class Serie {

    use Uuid;

    public $id;
    public $uuid;
    public $nome;
    public $descricao;
    public $imagem;
    public $banner;
    public $ativo;
    public $created_at;
    public $updated_at;

    public function create(array $data) : Serie {
        $serie = new Serie();
        $serie->id = $data['id'] ?? null;
        $serie->uuid = $data['uuid'] ?? $this->generateUUID();
        $serie->nome = $data['nome'] ?? null;
        $serie->descricao = $data['descricao'] ?? null;
        $serie->imagem = $data['imagem'] ?? null;
        $serie->banner = $data['banner'] ?? null;
        $serie->banner = $data['banner'] ?? null;
        $serie->ativo = (!isset($data['ativo']) || $data['ativo'] == "") ? 1 : $data['ativo'];
        $serie->created_at = $data['created_at'] ?? null;
        $serie->updated_at = $data['updated_at'] ?? null;
        return $serie;
    }

}