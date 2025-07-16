<?php

namespace App\Interfaces\Episodio;

interface IEpisodio {

    public function all(array $params = []);

    public function create(array $data, int $temporadas_id);

    public function update(array $data, int $temporadas_id, int $id);

    public function delete(int $id);

    public function findById(int $id);

    public function findByUuid(string $uuid);

}