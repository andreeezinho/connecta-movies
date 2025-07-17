<?php

namespace App\Models\Filme;

use App\Models\Traits\Uuid;

class Filme {

    use Uuid;

    public $id;
    public $uuid;
    public $nome;
    public $descricao;
    public $imagem;
    public $banner;
    public $path;
    public $ativo;
    public $created_at;
    public $updated_at;

    public function create(array $data) : Filme {
        $filme = new Filme();
        $filme->id = $data['id'] ?? null;
        $filme->uuid = $data['uuid'] ?? $this->generateUUID();
        $filme->nome = $data['nome'] ?? null;
        $filme->descricao = $data['descricao'] ?? null;
        $filme->imagem = (!isset($data['imagem']) ||  $data['imagem'] == "") ? "default.png" : $data['imagem'];
        $filme->banner = (!isset($data['banner']) ||  $data['banner'] == "") ? "default.png" : $data['banner'];
        $filme->path = $data['filme'] ?? null;
        $filme->ativo = (!isset($data['ativo']) || $data['ativo'] == "") ? 1 : $data['ativo'];
        $filme->created_at = $data['created_at'] ?? null;
        $filme->updated_at = $data['updated_at'] ?? null;
        return $filme;
    }
    
}