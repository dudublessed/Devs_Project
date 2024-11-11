<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

Class Associates {
    private static $pdo;

    public static function setConnection($pdo) {
        self::$pdo = $pdo;
    }

    public static function all() {
        $stmt = self::$pdo->query("SELECT * FROM associates");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$pdo->prepare("SELECT * FROM associates WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $stmt = self::$pdo->prepare("INSERT INTO associates (nome, email, cpf, data_filiacao) VALUES (:nome, :email, :cpf, :data_filiacao)");
        $stmt->execute(['nome' => $data['nome'], 'email' => $data['email'], 'cpf' => $data['cpf'], 'data_filiacao' => $data['data_filiacao']]);
    }

    public static function update($id, $nome, $email, $cpf, $data_filiacao) {
        try {
            $sql = "UPDATE associates 
                    SET nome = :nome, 
                        email = :email, 
                        cpf = :cpf, 
                        data_filiacao = :data_filiacao
                    WHERE id = :id";
    
            $stmt = self::$pdo->prepare($sql);
            
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->bindParam(':data_filiacao', $data_filiacao, PDO::PARAM_STR); 
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            $stmt->execute();
    
        } catch (PDOException $e) {
            echo "Erro ao atualizar associado: " . $e->getMessage();
        }
    }

    public static function delete($associateId) {
        try {
            self::$pdo->beginTransaction();

            $associatedAnnuitiesSQL = "DELETE FROM associate_annuities WHERE associate_id = :id";
            $stmt1 = self::$pdo->prepare($associatedAnnuitiesSQL);
            $stmt1->bindParam(':id', $associateId, PDO::PARAM_INT);
            $stmt1->execute();
    
            $associateSQL = "DELETE FROM associates WHERE id = :id";
            $stmt2 = self::$pdo->prepare($associateSQL);
            $stmt2->bindParam(':id', $associateId, PDO::PARAM_INT);
            $stmt2->execute();
    
            self::$pdo->commit();
    
            header("Location: /associates");
            exit();
        } catch (PDOException $e) {
            self::$pdo->rollBack();
    
            echo "Erro ao excluir associado: " . $e->getMessage();
        }
    }

    public static function findByEmail($email) {
        try {
            $sql = "SELECT * FROM associates WHERE email = :email LIMIT 1";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar o e-mail: " . $e->getMessage();
            return null;
        }
    }

    public static function checkAssociatesExist($ano) {
        $startOfYear = $ano . '-01-01';
    
        $stmt = self::$pdo->prepare("SELECT COUNT(id) FROM associates WHERE data_filiacao <= ?");
        $stmt->execute([$startOfYear]);
    
        $result = $stmt->fetchColumn();
        return $result > 0;
    }
    
 }
