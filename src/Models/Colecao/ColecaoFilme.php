<?php

namespace App\Models\Colecao;

use App\Models\Traits\Uuid;

class ColecaoFilme {

    use Uuid;

    public $id;
    public $uuid;
    public $colecoes_id;
    public $colecao_uuid;
    public $colecao_nome;
    public $colecao_descricao;
    public $filmes_id;
    public $filme_uuid;
    public $filme_nome;
    public $imagem;
    public $created_at;
    public $updated_at;

    public function create(array $data, int $colecoes_id, int $filmes_id) : ColecaoFilme {
        $colecao = new ColecaoFilme();
        $colecao->id = $data['id'] ?? null;
        $colecao->uuid = $data['uuid'] ?? $this->generateUUID();
        $colecao->colecoes_id = $colecoes_id ?? null;
        $colecao->filmes_id = $filmes_id ?? null;
        $colecao->created_at = $data['created_at'] ?? null;
        $colecao->updated_at = $data['updated_at'] ?? null;
        return $colecao;
    }

}