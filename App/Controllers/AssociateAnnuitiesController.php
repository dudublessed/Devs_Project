<?php
namespace App\Controllers;

use App\Models\AssociatedAnnuities;
use App\Models\Associates;

class AssociateAnnuitiesController {

    public function index() {
        require_once __DIR__ . '/../Views/home.php';
    }

    public function checkout_associated($id) {
        $associate = Associates::find($id);
        $associatedAnnuities = AssociatedAnnuities::find($id);
        $isOverdue = AssociatedAnnuities::isAssociateOverdue($id);
        $totalAnnuitiesDebt = 0;

        if ($associatedAnnuities) {
            foreach ($associatedAnnuities as $annuity) {
                if (!$annuity['pagamento_efetuado'] ) {
                    $totalAnnuitiesDebt += $annuity['annuity_valor'];
                }      
            }

            $status = $isOverdue ? "Pagamento atrasado" : "Pagamento em dia";
        }

        extract(['associate_annuities' => $associatedAnnuities]); 
        require_once __DIR__ . '/../Views/associated_checkout.php';
    }

    public function pay_annuity($data) {
        $id = $data['id'];

        $pagamento_efetuado = AssociatedAnnuities::findPaymentById($id);

        if ($pagamento_efetuado == false) {
            AssociatedAnnuities::paymentFlag(true, $id);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();   
        } else {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } 
    }  

    public function pay_all_annuities($data) {
        $id = $data['id'];
    
        var_dump($id);

        $associatedAnnuities = AssociatedAnnuities::find($id);
    
        if ($associatedAnnuities) {
            foreach ($associatedAnnuities as $annuity) {
                $pagamento_efetuado = AssociatedAnnuities::findPaymentById($annuity['id']);
    
                if ($pagamento_efetuado == false) {
                    AssociatedAnnuities::paymentFlag(true, $annuity['id']);
                }
            }
    
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    
}
