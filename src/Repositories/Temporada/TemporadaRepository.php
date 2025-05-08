<?php

namespace App\Repositories\Temporada;

use App\Config\Database;
use App\Interfaces\Temporada\ITemporada;
use App\Models\Temporada\Temporada;
use App\Repositories\Traits\Find;

class TemporadaRepository implements ITemporada {

    const CLASS_NAME = Temporada::class;
    const TABLE = 'temporadas';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Temporada();
    }

    public function all(array $params = []){
        $sql = "SELECT * FROM " . self::TABLE;
    
        $conditions = [];
        $bindings = [];

        if(isset($params['numero']) && $params['numero'] != ""){
            $conditions[] = "numero = :numero";
            $bindings[':numero'] = $params['numero'];
        }

        if(isset($params['series_id']) && $params['series_id'] != ""){
            $conditions[] = "series_id = :series_id";
            $bindings[':series_id'] = $params['series_id'];
        }
    
        if(isset($params['ativo']) && $params['ativo'] != ""){
            $conditions[] = "ativo = :ativo";
            $bindings[':ativo'] = $params['ativo'];
        }
    
        if(count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data, int $series_id){
        $temporada = $this->model->create($data, $series_id);

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    numero = :numero,
                    series_id = :series_id,
                    ativo = :ativo
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $temporada->uuid,
                ':numero' => $temporada->numero,
                ':series_id' => $temporada->series_id,
                ':ativo' => $temporada->ativo
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($temporada->uuid);

        }catch (\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $series_id, int $id){
        $temporada = $this->model->create($data, $series_id);
        
        try{
            $sql = "UPDATE " . self::TABLE . "
                SET
                    numero = :numero,
                    ativo = :ativo
                WHERE
                    series_id = :series_id
                AND
                    id = :id
                    
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':numero' => $temporada->numero,
                ':series_id' => $temporada->series_id,
                ':ativo' => $temporada->ativo,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            return $this->findById($id);

        }catch (\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function delete(int $id){
        try{
            $sql = "UPDATE " . self::TABLE . "
                SET
                    ativo = :ativo
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $delete = $stmt->execute([
                ':ativo' => 0,
                ':id' => $id
            ]);

            return $delete;

        }catch (\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

}