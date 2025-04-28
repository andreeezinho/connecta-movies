<?php

namespace App\Interfaces\User;

interface IUser {

    public function login(string $email, string $senha);

    public function all(array $params);

    public function create(array $data);

    public function update(array $data, int $id);

    public function updateIcone(int $id, array $icone, string $dir);

    public function updateSenha(array $data, int $id);

    public function delete(int $id);

    public function findById(int $id);

    public function findByUuid(string $uuid);

}