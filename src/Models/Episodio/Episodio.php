<?php

namespace App\Models\Episodio;

use App\Models\Traits\Uuid;

class Episodio {

    use Uuid;

    public $id;
    public $uuid;
    public $numero;
    public $nome;
    public $descricao;
    public $path;
    public $temporadas_id;
    public $ativo;
    public $created_at;
    public $updated_at;

    public function create(array $data, int $temporadas_id) : Episodio {
        $episodio = new Episodio();
        $episodio->id = $data['id'] ?? null;
        $episodio->uuid = $data['uuid'] ?? $this->generateUUID();
        $episodio->numero = $data['numero'] ?? null;
        $episodio->nome = $data['nome'] ?? null;
        $episodio->descricao = $data['descricao'] ?? null;
        $episodio->path = $data['path'] ?? null;
        $episodio->temporadas_id = $temporadas_id ?? null;
        $episodio->ativo = (!isset($data['ativo']) || $data['ativo'] == "") ? 1 : $data['ativo'];
        $episodio->created_at = $data['created_at'] ?? null;
        $episodio->updated_at = $data['updated_at'] ?? null;
        return $episodio;
    }

}