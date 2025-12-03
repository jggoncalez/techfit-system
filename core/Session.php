<?php

namespace core;

class Session
{
    private $conn;
    public $user_ID;
    public $user_name;
    public $user_pass;
    public $user_type;

    public function __construct($db)
    {
        $this->conn = $db;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function userLogin()
    {
        $query = 'SELECT US_ID, US_NOME FROM USUARIOS 
              WHERE US_NOME = :us_nome 
              AND US_SENHA = :us_senha 
              LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':us_nome', $this->user_name);
        $stmt->bindParam(':us_senha', $this->user_pass);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            $_SESSION['user_ID'] = $row['US_ID'];
            $_SESSION['user_Name'] = $row['US_NOME'];
            $_SESSION['type'] = 'user'; 
            
            return true;
        }
        return false;
    }

    public function funcLogin()
    {
        $query = 'SELECT FU_ID, FU_NOME FROM FUNCIONARIOS
              WHERE FU_NOME = :fu_nome 
              AND FU_SENHA = :fu_senha 
              LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':fu_nome', $this->user_name);
        $stmt->bindParam(':fu_senha', $this->user_pass);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            $_SESSION['user_ID'] = $row['FU_ID'];
            $_SESSION['user_Name'] = $row['FU_NOME'];
            $_SESSION['type'] = 'func';
            
            return true;
        }
        return false;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_ID']);
    }

    public function getUserID()
    {
        return $_SESSION['user_ID'] ?? null;
    }

    public function getUserName(){
        return $_SESSION['user_Name'] ?? null;
    }

    public function getUserType()
    {
        return $_SESSION['type'] ?? null;
    }

    public function logout()
    {
        $_SESSION = [];
        session_unset();
        session_destroy();
    }
}