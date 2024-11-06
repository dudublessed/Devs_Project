<?php

namespace App\Models;

use PDO;

Class Associates {
    private static $pdo;

    public static function setConnection($pdo) {
        self::$pdo = $pdo;
    }

    public static function all() {
        $stmt = self::$pdo->query("SELECT * FROM associates");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $stmt = self::$pdo->prepare("INSERT INTO associates (nome, email, cpf, data_filiacao) VALUES (:nome, :email, :cpf, :data_filiacao)");
        $stmt->execute(['nome' => $data['nome'], 'email' => $data['email'], 'cpf' => $data['cpf'], 'data_filiacao' => $data['data_filiacao']]);
    }
 }
