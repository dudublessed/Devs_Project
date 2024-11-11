<?php
namespace App\Models;

use PDO;
use PDOException;
use Exception;

class AssociatedAnnuities {
    private static $pdo;

    public static function setConnection($pdo) {
        self::$pdo = $pdo;
    }

    public static function find($id) {
        $stmt = self::$pdo->prepare("SELECT * FROM associate_annuities WHERE associate_id = :id ORDER BY annuity_ano ASC");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function associateAnnuityToAssociate($associateId, $annuityId) {
        $stmt = self::$pdo->prepare("SELECT ano, valor FROM annuities WHERE id = ?");
        $stmt->execute([$annuityId]);
        $annuity = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($annuity) {
            $stmt = self::$pdo->prepare(
                "INSERT INTO associate_annuities (associate_id, annuity_ano, annuity_valor, pagamento_efetuado)
            VALUES (?, ?, ?, FALSE)"
            );
            $stmt->execute([$associateId, $annuity['ano'], $annuity['valor']]);
        } else {
            throw new Exception("Anuidade não encontrada para o erro fornecido.");
        }
    }    

    public static function findPaymentById($id) {
        $stmt = self::$pdo->prepare("SELECT pagamento_efetuado FROM associate_annuities WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result ? $result['pagamento_efetuado'] : null;
    }
    
    public static function paymentFlag($pagamento_efetuado, $id) {
        $stmt = self::$pdo->prepare("UPDATE associate_annuities SET pagamento_efetuado = ? WHERE id = ?");
        $stmt->execute([$pagamento_efetuado, $id]);  

    }

    public static function isAssociateOverdue($id) {
        $currentYear = date('Y');

        $stmt = self::$pdo->prepare("SELECT annuity_ano, pagamento_efetuado FROM associate_annuities WHERE associate_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $annuities = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($annuities) {
            foreach($annuities as $annuity) {
                if ($annuity['annuity_ano'] <= $currentYear && !$annuity['pagamento_efetuado']) {
                    return true; 
                }            
            }
    
            return false;
        }
    }
    
    
}