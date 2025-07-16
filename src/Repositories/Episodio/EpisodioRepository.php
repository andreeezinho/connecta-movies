<?php

namespace App\Repositories\Episodio;

use App\Config\Database;
use App\Interfaces\Episodio\IEpisodio;
use App\Models\Episodio\Episodio;
use App\Repositories\Traits\Find;

class EpisodioRepository implements IEpisodio {

    const CLASS_NAME = Episodio::class;
    const TABLE = 'episodios';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Episodio();
    }

    public function all(array $params = []){
        $sql = "SELECT * FROM " . self::TABLE;
    
        $conditions = [];
        $bindings = [];

        if(isset($params['temporadas_id']) && $params['temporadas_id'] != ""){
            $conditions[] = "temporadas_id = :temporadas_id";
            $bindings[':temporadas_id'] = $params['temporadas_id'];
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

        $sql .= " ORDER BY numero ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data, int $temporadas_id){
        $episodio = $this->model->create($data, $temporadas_id);

        $video = createFile($data['episodio'], '/conteudos/series', 'video');

        if(is_null($video)){
            return null;
        }

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    numero = :numero,
                    nome = :nome,
                    descricao = :descricao,
                    path = :path,
                    temporadas_id = :temporadas_id,
                    ativo = :ativo
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $episodio->uuid,
                ':numero' => $episodio->numero,
                ':nome' => $episodio->nome,
                ':descricao' => $episodio->descricao,
                ':path' => $video['arquivo_nome'],
                ':temporadas_id' => $episodio->temporadas_id,
                ':ativo' => $episodio->ativo
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($episodio->uuid);

        }catch(\Throwable $th){
            return $th;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $temporadas_id, int $id){
        $episodio = $this->model->create($data, $temporadas_id);

        try{
            $sql = "UPDATE " . self::TABLE . "
                SET
                    numero = :numero,
                    nome = :nome,
                    descricao = :descricao,
                    ativo = :ativo
                WHERE
                    temporadas_id = :temporadas_id
                AND
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':numero' => $episodio->numero,
                ':nome' => $episodio->nome,
                ':descricao' => $episodio->descricao,
                ':ativo' => $episodio->ativo,
                ':temporadas_id' => $temporadas_id,
                ':id' => $id
            ]);

            if(!$update){
                return null;
            }

            return $this->findById($id);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function delete(int $id){
        try{
            $sql = "UPDATE " . self::TABLE . "
                SET 
                    ativo = 0
                WHERE 
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $delete = $stmt->execute([
                ':id' => $id
            ]);

            return $delete;
            
        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function findByNumberAndTempId(int $number, int $temp_id){
        $stmt = $this->conn->prepare(
            "SELECT * FROM " . self::TABLE . " 
                WHERE 
                    numero = :numero 
                AND 
                    temporadas_id = :temp_id
                "
        );

        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::CLASS_NAME);
        $result = $stmt->fetch();

        if(is_null($result)){
            return null;
        }

        return $result;
    }

}