<?php

namespace App\Repositories\Lista;

use App\Config\Database;
use App\Interfaces\Lista\ILista;
use App\Models\Lista\Lista;
use App\Repositories\Traits\Find;
use App\Repositories\User\UserRepository;
use App\Repositories\Filme\FilmeRepository;

class ListaRepository implements ILista {

    const CLASS_NAME = Lista::class;
    const TABLE = 'listas';

    use Find;

    protected $conn;
    protected $model;
    protected $userRepository;
    protected $filmeRepository;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Lista();
        $this->userRepository = new UserRepository();
        $this->filmeRepository = new FilmeRepository();
    }

    public function all(array $params, $usuarios_id){
        $sql = "SELECT l.*,
            f.uuid as filme_uuid, f.nome, f.imagem, f.ativo
            FROM " . self::TABLE . " l
            JOIN filmes f
                ON id_conteudo = f.id
            WHERE
                usuarios_id = :usuarios_id
            AND
            ";
    
        $conditions = [];
        $bindings = [];
    
        if(isset($params['nome']) && !empty($params['nome'])){
            $conditions[] = "f.nome LIKE :nome";
            $bindings[':nome'] = "%" . $params['nome'] . "%";
        }

        if(isset($params['tipo']) && !empty($params['tipo'])){
            $conditions[] = "tipo = :tipo";
            $bindings[':tipo'] = $params['tipo'];
        }
    
        if(isset($params['ativo']) && $params['ativo'] != ""){
            $conditions[] = "f.ativo = :ativo";
            $bindings[':ativo'] = $params['ativo'];
        }
    
        if(count($conditions) > 0) {
            $sql .= implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);

        $bindings = array_merge($bindings, [':usuarios_id' => $usuarios_id]);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data, int $id_conteudo, int $usuarios_id){
        $lista = $this->model->create($data, $id_conteudo, $usuarios_id);

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    id_conteudo = :id_conteudo,
                    tipo = :tipo,
                    usuarios_id = :usuarios_id
                    
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $lista->uuid,
                ':id_conteudo' => $lista->id_conteudo,
                ':tipo' => $lista->tipo,
                ':usuarios_id' => $lista->usuarios_id
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($lista->uuid);

        }catch(\Throwable $th){
            return $th;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function delete(int $id_conteudo, int $usuarios_id, string $tipo){
        try{
            $sql = "DELETE FROM " . self::TABLE . "
                WHERE
                    tipo = :tipo
                AND
                    id_conteudo = :id_conteudo
                AND
                    usuarios_id = :usuarios_id
            ";

            $stmt = $this->conn->prepare($sql);

            $delete = $stmt->execute([
                ':tipo' => $tipo,
                ':id_conteudo' => $id_conteudo,
                ':usuarios_id' => $usuarios_id
            ]);

            return $delete;

        }catch(\Throwable $th){
            return $th;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function findByUserAndContentId(int $usuarios_id, int $id_conteudo, string $tipo){
        $stmt = $this->conn->prepare(
            "SELECT * FROM " . self::TABLE . " 
            WHERE 
                tipo = :tipo
            AND
                usuarios_id = :usuarios_id 
            AND
                id_conteudo = :id_conteudo"
        );

        $stmt->execute([
            ':usuarios_id' => $usuarios_id,
            ':id_conteudo' => $id_conteudo,
            ':tipo' => $tipo
        ]);

        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::CLASS_NAME);
        $result = $stmt->fetch();

        if(is_null($result)){
            return null;
        }

        return $result;
    }

}