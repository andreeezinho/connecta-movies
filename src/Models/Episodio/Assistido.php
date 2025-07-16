<?php

namespace App\Models\Episodio;

use App\Models\Traits\Uuid;

class Assistido {

    use Uuid;

    public $id;
    public $uuid;
    public $usuarios_id;
    public $episodios_id;
    public $created_at;
    public $updated_at;

    public function create(array $data = null, int $usuarios_id, int $episodios_id) : Assistido {
        $assistido = new Assistido();
        $assistido->id = $data['id'] ?? null;
        $assistido->uuid = $data['uuid'] ?? $this->generateUUID();
        $assistido->usuarios_id = $usuarios_id ?? null;
        $assistido->episodios_id = $episodios_id ?? null;
        $assistido->created_at = $data['created_at'] ?? null;
        $assistido->updated_at = $data['updated_at'] ?? null;
        return $assistido;
    }

}