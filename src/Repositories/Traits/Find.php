<?php

namespace App\Repositories\Traits;

trait Find {

    public function findById($id){
        $stmt = $this->conn->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE id = :id"
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

    public function findByUuid($uuid){
        $stmt = $this->conn->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE uuid = :uuid"
        );

        $stmt->execute([':uuid' => $uuid]);

        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::CLASS_NAME);
        $result = $stmt->fetch();

        if(empty($result)){
            return null;
        }

        return $result;
    }

    public function random(){
        $sql = "SELECT * FROM " . self::TABLE ."
            WHERE
                ativo = :ativo
            ORDER BY RAND()
            LIMIT 12";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':ativo' => 1
        ]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::CLASS_NAME);
    }

}