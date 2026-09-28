<?php
class CRUD extends PDO {

    public function __construct(){
        parent::__construct('mysql:host=localhost; dbname=xurhtuguwt_recettes; port=3306; charset=utf8mb4', 'xurhtuguwt_admin', 'Recette2026!Maisonneuve');
    }

    public function select(string $table, $field = "id", $order = "ASC"): array {
        $sql = "SELECT * FROM $table ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    public function selectId(string $table, int|string $value, $field = 'id'): bool|array {
        $sql = "SELECT * FROM $table WHERE $field = :$field";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count == 1) {
            return $stmt->fetch();
        } else {
            return false;
        }
    }

    public function insert(string $table, array $data): bool|int {
        // ex: INSERT INTO recette (titre, description, ...) VALUES (:titre, :description, ...)
        $fieldName = implode(', ', array_keys($data));
        $fieldBindValue = ":".implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($fieldName) VALUES ($fieldBindValue);";
        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            return $this->lastInsertId();
        } else {
            return false;
        }
    }

    public function update(string $table, array $data, $field = 'id'): bool {
        // ex: UPDATE recette SET titre = :titre, description = :description WHERE id = :id
        $fieldName = null;
        foreach ($data as $key => $value) {
            $fieldName .= "$key = :$key, ";
        }
        $fieldName = rtrim($fieldName, ', ');
        $sql = "UPDATE $table SET $fieldName WHERE $field = :$field;";
        $stmt = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(string $table, int|string $value, $field = 'id'): bool {
        $sql = "DELETE FROM $table WHERE $field = :$field";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
