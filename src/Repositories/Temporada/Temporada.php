<?php

namespace App\Repositories\Temporada;

use App\Config\Database;
use App\Interfaces\Temporada\ITemporada;
use App\Models\Temporada\Temporada;
use App\Repositories\Traits\Find;

class TemporadaRepository implements ITemporada {

    const CLASS_NAME = Temporada::class;
    const TABLE = 'series';

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

        if(isset($params['series_id']) && $params['series_id'] != ""){
            $conditions[] = "series_id = :series_id";
            $bindings[':series_id'] = $params['series_id'];
        }
    
        if(isset($params['nome']) && !empty($params['nome'])){
            $conditions[] = "nome LIKE :nome";
            $bindings[':nome'] = "%" . $params['nome'] . "%";
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

    public function create(array $data, int $series_id){}

    public function update(array $data, int $id){}

    public function delete(int $id){}

}