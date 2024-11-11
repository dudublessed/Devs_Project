<?php

namespace App\Models;

use App\Models\AssociatedAnnuities;
use PDO;
use PDOException;

class Annuities {
    private static $pdo;

    public static function setConnection($pdo) {
        self::$pdo = $pdo;
    }

    public static function all() {
        $stmt = self::$pdo->query("SELECT * FROM annuities");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$pdo->prepare("SELECT * FROM annuities WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public static function create($data) {
        $stmt = self::$pdo->prepare("INSERT INTO annuities (ano, valor) VALUES (:ano, :valor)");
        $stmt->execute([
            'ano' => $data['ano'],
            'valor' => $data['valor'],
        ]);
    }

    public static function update($id, $valor) {
        $stmt = self::$pdo->prepare("UPDATE annuities SET valor = :valor WHERE id = :id");
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function delete($annuityId) {
        try {
            $stmt = self::$pdo->prepare("DELETE FROM annuities WHERE id = :id");
            $stmt->bindParam(':id', $annuityId, PDO::PARAM_INT);
            $stmt->execute();
            
            header("Location: /annuities");
            exit();
        } catch (PDOException $e) {
            echo "Erro ao excluir a anuidade: " . $e->getMessage();
        }
    }    

    public static function findByYear($ano) {
        $stmt = self::$pdo->prepare("SELECT * FROM annuities WHERE ano = ?");
        $stmt->execute([$ano]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }    

    public static function findAnnuitiesByYear($ano_filiacao) {
        $stmt = self::$pdo->prepare("SELECT * FROM annuities WHERE ano >= ?");
        $stmt->execute([$ano_filiacao]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }   
    
    public static function associate_annuities($ano) {
        $startOfYear = $ano . '-01-01';
    
        $annuityId = self::$pdo->lastInsertId();
    
        $stmt = self::$pdo->prepare("SELECT id FROM associates WHERE data_filiacao <= ?");
        $stmt->execute([$startOfYear]);
    
        $associates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($associates as $associate) {
            AssociatedAnnuities::associateAnnuityToAssociate($associate['id'], $annuityId);
        }
    }
    
    
}