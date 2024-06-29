<?php
namespace Models;

use PDO;

require_once 'models/credentials.php';

class BaseModel
{
    protected $pdo = NULL;
    protected string $prefix = 'p79k8_';

    protected function connectDb()
    {
        $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);

    }

    protected function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    protected function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    protected function commit()
    {
        return $this->pdo->commit();
    }

    protected function rollBack()
    {
        return $this->pdo->rollBack();
    }
}
