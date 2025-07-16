<?php

namespace App\Interfaces\Lista;

interface ILista {

    public function all(array $params, $usuarios_id);

    public function create(array $data, int $id_conteudo, int $usuarios_id);

    public function delete(int $id_conteudo, int $usuarios_id, string $tipo);

    public function findByUserAndContentId(int $usuarios_id, int $id_conteudo, string $tipo);

    public function findById(int $id);

    public function findByUuid(string $uuid);

}