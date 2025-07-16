<?php

namespace App\Interfaces\Filme;

interface IFilme {

    public function all(array $params = []);

    public function random();

    public function create(array $data);

    public function update(array $data, int $id);

    public function updateImage(string $type, string $oldImage, array $image, string $dir, int $id);

    public function delete(int $id);

    public function findById(int $id);

    public function findByUuid(string $uuid);

}