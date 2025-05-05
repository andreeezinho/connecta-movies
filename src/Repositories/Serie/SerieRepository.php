<?php

namespace App\Repositories\Serie;

use App\Config\Database;
use App\Interfaces\Serie\ISerie;
use App\Models\Serie\Serie;
use App\Repositories\Traits\Find;

class SerieRepository implements ISerie {

    const CLASS_NAME = Serie::class;
    const TABLE = 'series';

    use Find;

    protected $conn;
    protected $model;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
        $this->model = new Serie();
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

    public function randomSeries(){
        $sql = "SELECT * FROM " . self::TABLE ."
            WHERE
                ativo = :ativo
            ORDER BY RAND()
            LIMIT 10";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':ativo' => 1
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

    public function create(array $data){
        $serie = $this->model->create($data);

        $imagem = createImage($data['imagem'], '/conteudos/capas/series');

        $banner = createImage($data['banner'], '/conteudos/banners/series');

        try{
            $sql = "INSERT INTO " . self::TABLE . "
                SET
                    uuid = :uuid,
                    nome = :nome,
                    descricao = :descricao,
                    imagem = :imagem,
                    banner = :banner,
                    ativo = :ativo
            ";

            $stmt = $this->conn->prepare($sql);

            $create = $stmt->execute([
                ':uuid' => $serie->uuid,
                ':nome' => $serie->nome,
                ':descricao' => $serie->descricao,
                ':imagem' => $imagem['arquivo_nome'] ?? null,
                ':banner' => $banner['arquivo_nome'] ?? null,
                ':ativo' => $serie->ativo
            ]);

            if(!$create){
                return null;
            }

            return $this->findByUuid($serie->uuid);

        }catch (\Throwable $th){
            return null;
        }finally{
            Database::getInstance()->closeConnection();
        }
    }

    public function update(array $data, int $id){}

    public function updateImage(string $type, string $oldImage, array $image, string $dir, int $id){}

    public function delete(int $id){}

}