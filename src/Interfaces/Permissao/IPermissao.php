<?php

namespace App\Interfaces\Permissao;

interface IPermissao {

    public function all(array $params);

    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function findById(int $id);

    public function findByUuid(string $uuid);

}