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

        $imagem = createImage($data['imagem'], '/conteudos/capas/filmes');

        $banner = createImage($data['banner'], '/conteudos/banners/filmes');

        $video = createVideo($data['filme'], '/filmes');

        if(is_null($video)){
            return null;
        }

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                set
                    uuid = :uuid,
                    nome = :nome,
                    descricao = :descricao,
                    imagem = :imagem,
                    banner = :banner,
                    path = :path
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                'uuid' => $filme->uuid,
                'nome' => $filme->nome,
                'descricao' => $filme->descricao,
                'imagem' => $imagem['arquivo_nome'],
                'banner' => $banner['arquivo_nome'],
                'path' => $video['arquivo_nome']
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
        try{
            
        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function delete(int $id){
        try{
            
        }catch(\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

}