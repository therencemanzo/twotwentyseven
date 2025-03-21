<?php

namespace App\Tools;

use \Exception;

class UserManger
{
    private $db;
    private $logger;

    public function __construct($database, $log)
    {
        $this->db = $database;
        $this->logger = $log;
    }

    public function getUser($id): ?array
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $statement->execute(['id' => $id]);
            return $statement->fetch() ?: null;
        } catch (Exception $e) {
            $this->logger->log($e->getMessage());
            return null;
        }
    }

    public function createUser(array $userData): bool
    {
        // TODO: Implement user creation logic
        return true;
    }
}
