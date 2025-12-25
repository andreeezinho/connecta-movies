<?php

namespace App\Models\Colecao;

use App\Models\Traits\Uuid;

class Colecao {

    use Uuid;

    public $id;
    public $uuid;
    public $nome;
    public $ativo;
    public $created_at;
    public $updated_at;

    public function create(array $data) : Colecao {
        $colecao = new Colecao();
        $colecao->id = $data['id'] ?? null;
        $colecao->uuid = $data['uuid'] ?? $this->generateUUID();
        $colecao->nome = $data['nome'] ?? null;
        $colecao->ativo = (!isset($data['ativo']) || $data['ativo'] == "") ? 1 : $data['ativo'];
        $colecao->created_at = $data['created_at'] ?? null;
        $colecao->updated_at = $data['updated_at'] ?? null;
        return $colecao;
    }

}