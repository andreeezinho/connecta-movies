<?php

namespace App\Interfaces\Episodio;

interface IAssistido {

    public function all(array $params = null);

    public function create(array $data = null, int $usuarios_id, int $episodios_id);

    public function findByUserAndEpisodeId(int $usuarios_id, int $episodios_id);

    public function findById(int $id);

    public function findByUuid(string $uuid);

}