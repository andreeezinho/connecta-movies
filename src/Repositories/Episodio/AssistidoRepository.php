<?php

namespace App\Repositories\Episodio;

use App\Config\Database;
use App\Interfaces\Episodio\IAssistido;
use App\Models\Episodio\Assistido;
use App\Repositories\Traits\Find;

class AssistidoRepository implements IAssistido {

    const CLASS_NAME = Assistido::class;
    const TABLE = 'assistidos';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Assistido();
    }

    public function all(array $params = null){
        $sql = "SELECT * FROM " . self::TABLE;
    
        $conditions = [];
        $bindings = [];

        if(isset($params['usuarios_id']) && $params['usuarios_id'] != ""){
            $conditions[] = "usuarios_id = :usuarios_id";
            $bindings[':usuarios_id'] = $params['usuarios_id'];
        }

        if(isset($params['episodios_id']) && $params['episodios_id'] != ""){
            $conditions[] = "episodios_id = :episodios_id";
            $bindings[':episodios_id'] = $params['episodios_id'];
        }
    
        if(count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data = null, int $usuarios_id, int $episodios_id){
        $assistido = $this->model->create($data, $usuarios_id, $episodios_id);

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    usuarios_id = :usuarios_id,
                    episodios_id = :episodios_id
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $assistido->uuid,
                ':usuarios_id' => $assistido->usuarios_id,
                ':episodios_id' => $assistido->episodios_id
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($assistido->uuid);

        }catch(\Throwable $th){
            return null; 
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function findByUserAndEpisodeId(int $usuarios_id, int $episodios_id){
        try{
            $sql = "SELECT * FROM " . self::TABLE . "
                WHERE
                    usuarios_id = :usuarios_id
                AND
                    episodios_id = :episodios_id
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':usuarios_id' => $usuarios_id,
                ':episodios_id' => $episodios_id
            ]);

            $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::CLASS_NAME);
            $result = $stmt->fetch();

            if(empty($result)){
                return null;
            }

            return $result;

        }catch(\Throwable $th){
            return $th;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

}