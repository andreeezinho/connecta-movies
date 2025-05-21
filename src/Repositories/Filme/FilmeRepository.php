<?php

namespace App\Repositories\Filme;

use App\Config\Database;
use App\Interfaces\Filme\IFilme;
use App\Models\Filme\Filme;
use App\Repositories\Traits\Find;

class FilmeRepository implements IFilme {

    const CLASS_NAME = Filme::class;
    const TABLE = 'filmes';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Filme();
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

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($bindings);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data){
        $filme = $this->model->create($data);

        $imagem = createFile($data['imagem'], '/img/conteudos/capas/filmes', 'image');

        $banner = createFile($data['banner'], '/img/conteudos/banners/filmes', 'image');

        $video = createFile($data['filme'], '/conteudos/filmes', 'video');

        if(is_null($video)){
            return null;
        }

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    nome = :nome,
                    descricao = :descricao,
                    imagem = :imagem,
                    banner = :banner,
                    path = :path
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $filme->uuid,
                ':nome' => $filme->nome,
                ':descricao' => $filme->descricao,
                ':imagem' => $imagem['arquivo_nome'] ?? 'default.png',
                ':banner' => $banner['arquivo_nome'] ?? 'default.png',
                ':path' => $video['arquivo_nome']
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($filme->uuid);

        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $id){
        $filme = $this->model->create($data);

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
                ':nome' => $filme->nome,
                ':descricao' => $filme->descricao,
                ':ativo' => $filme->ativo,
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

    public function updateImage(string $type, string $oldImage, array $image, string $dir, int $id){
        $delete = removeImage($oldImage, $dir);

        if(!$delete){
            return null;
        }

        $newImage = createFile($image, $dir, 'image');

        if(is_null($newImage)){
            return null;
        }

        try{
            $sql = "UPDATE " . self::TABLE . "
                SET
                    {$type} = :image
                WHERE
                    id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $update = $stmt->execute([
                ':image' => $newImage['arquivo_nome'],
                ':id' => $id
            ]);

            if(is_null($update)){
                return null;
            }

            return $this->findById($id);
        }catch(\Throwable $th){
            dd($th);
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

}