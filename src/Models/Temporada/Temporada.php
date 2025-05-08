<?php

namespace App\Models\Temporada;

use App\Models\Traits\Uuid;

class Temporada {

    use Uuid;

    public $id;
    public $uuid;
    public $numero;
    public $series_id;
    public $ativo;
    public $created_at;
    public $updated_at;

    public function create(array $data, int $series_id) : Temporada {
        $temporada = new Temporada();
        $temporada->id = $data['id'] ?? null;
        $temporada->uuid = $data['uuid'] ?? $this->generateUUID();
        $temporada->numero = $data['numero'] ?? null;
        $temporada->series_id = $series_id ?? null;
        $temporada->ativo = (!isset($data['ativo']) || $data['ativo'] == "") ? 1 : $data['ativo'];
        $temporada->created_at = $data['created_at'] ?? null;
        $temporada->updated_at = $data['updated_at'] ?? null;
        return $temporada;
    }

}