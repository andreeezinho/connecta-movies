<?php

namespace App\Repositories\Colecao;

use App\Config\Database;
use App\Interfaces\Colecao\IColecaoFilme;
use App\Models\Colecao\ColecaoFilme;
use App\Repositories\Traits\Find;

class ColecaoFilmeRepository implements IColecaoFilme {

    const CLASS_NAME = ColecaoFilme::class;
    const TABLE = 'colecao_filme';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new ColecaoFilme();
    }

    public function allMoviesInCollection(int $collection_id){
        $sql = "SELECT 
                    cf.*, 
                    c.uuid as colecao_uuid, c.nome as colecao_nome, 
                    f.uuid as filme_uuid, f.nome as filme_nome, f.imagem as imagem 
            FROM " . self::TABLE . " cf
            JOIN
                colecoes c
            ON
                colecoes_id = c.id
            JOIN
                filmes f
            ON
                filmes_id = f.id
            WHERE 
                cf.colecoes_id = :colecao_id
        ";

        $sql .= " ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':colecao_id' => $collection_id
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function insertMovieInCollection(int $collection_id, int $movie_id){
        $colecao_filme = $this->model->create([], $collection_id, $movie_id);

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    colecoes_id = :colecoes_id,
                    filmes_id = :filmes_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $colecao_filme->uuid,
                ':colecoes_id' => $colecao_filme->colecoes_id,
                ':filmes_id' => $colecao_filme->filmes_id,
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($colecao_filme->uuid);

        }catch (\Throwable $th){
            return $th;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function removeMovieOfCollection(int $collection_id, int $movie_id){
         $sql = "DELETE FROM " . self::TABLE . "
            WHERE
                colecoes_id = :colecoes_id
            AND
                filmes_id = :filmes_id
        ";

        $stmt = $this->conn->prepare($sql);

        $delete = $stmt->execute([
            ':colecoes_id' => $collection_id,
            ':filmes_id' => $movie_id
        ]);

        return $delete;
    }

}