<?php

namespace App\Models\Lista;

use App\Models\Traits\Uuid;

class Lista {

    use Uuid;

    public $id;
    public $uuid;
    public $id_conteudo;
    public $tipo;
    public $filme_uuid;
    public $nome;
    public $imagem;
    public $ativo;
    public $usuarios_id;
    public $created_at;
    public $updated_at;

    public function create(array $data, int $id_conteudo, int $usuarios_id){
        $lista = new Lista();
        $lista->id = $data['id'] ?? null;
        $lista->uuid = $data['uuid'] ?? $this->generateUUID();
        $lista->id_conteudo = $id_conteudo;
        $lista->tipo = $data['tipo'] ?? null;
        $lista->usuarios_id = $usuarios_id ?? null;
        $lista->created_at = $data['created_at'] ?? null;
        $lista->updated_at = $data['updated_at'] ?? null;
        return $lista;
    }

}