<?php

namespace App\Repositories\Colecao;

use App\Config\Database;
use App\Interfaces\Colecao\IColecao;
use App\Models\Colecao\Colecao;
use App\Repositories\Traits\Find;

class ColecaoRepository implements IColecao {

    const CLASS_NAME = Colecao::class;
    const TABLE = 'colecoes';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Colecao();
    }

    public function all(array $params = []){
        $sql = "SELECT * FROM " . self::TABLE;
    
        $conditions = [];
        $bindings = [];
    
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

        $sql .= " ORDER BY id ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data){
        $colecao = $this->model->create($data);

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    nome = :nome,
                    descricao = :descricao,
                    ativo = :ativo
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $colecao->uuid,
                ':nome' => $colecao->nome,
                ':descricao' => $colecao->descricao,
                ':ativo' => $colecao->ativo
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($colecao->uuid);

        }catch (\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $id){
        $colecao = $this->model->create($data);
        
        try{
            $sql = "UPDATE " . self::TABLE . "
                SET
                    nome = :nome,
                    descricao = :descricao,
                    ativo = :ativo
                WHERE
                    id = :id
                    
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':nome' => $colecao->nome,
                ':descricao' => $colecao->descricao,
                ':ativo' => $colecao->ativo,
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