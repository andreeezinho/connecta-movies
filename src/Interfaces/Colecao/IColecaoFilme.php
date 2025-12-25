<?php

namespace App\Interfaces\Colecao;

interface IColecaoFilme {

    public function allMoviesInCollection(int $collection_id);

    public function insertMovieInCollection(int $collection_id, int $movie_id);

    public function removeMovieOfCollection(int $collection_id, int $movie_id);

    public function findById(int $id);

    public function findByUuid(string $uuid); 

}