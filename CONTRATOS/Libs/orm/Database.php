<?php
namespace Libs\ORM;

class Database {
    private static $instance = null;
    private $connection;
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'sistema_contratos';

    private function __construct() {
        try {
            $this->connection = new \PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                $this->user,
                $this->password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (\PDOException $e) {
            throw new \Exception("Error de conexión: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            throw new \Exception("Error en la consulta: " . $e->getMessage());
        }
    }

    public function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, $data);
        
        return $this->connection->lastInsertId();
    }

    public function update($table, $data, $where, $whereParams = []) {
        $sets = [];
        foreach (array_keys($data) as $column) {
            $sets[] = "{$column} = :{$column}";
        }
        
        $whereClause = '';
        if (!empty($where)) {
            $whereClause = " WHERE {$where}";
        }
        
        $sql = "UPDATE {$table} SET " . implode(', ', $sets) . $whereClause;
        $params = array_merge($data, $whereParams);
        
        return $this->query($sql, $params)->rowCount();
    }

    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        return $this->query($sql, $params)->rowCount();
    }
}