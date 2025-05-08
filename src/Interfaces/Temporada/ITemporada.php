<?php

namespace App\Interfaces\Temporada;

interface ITemporada {

    public function all(array $params = []);

    public function create(array $data, int $series_id);

    public function update(array $data, int $series_id, int $id);

    public function delete(int $id);

    public function findById(int $id);

    public function findByUuid(string $uuid); 

}