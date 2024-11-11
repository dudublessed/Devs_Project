<?php
namespace App\Controllers;

use App\Models\Annuities;
use App\Models\Associates;
use PDOException;
use Exception;

class AnnuityController {

    public function index() {
        require_once __DIR__ . '/../Views/home.php';
    }

    public function show_annuities() {
        $annuities = Annuities::all();
        extract(['annuities' => $annuities]); 
        require_once __DIR__ . '/../Views/annuities.php';
    }

    public function create_annuities() {
        $anoErr = $valErr = $exceptionErr = "";

        require_once __DIR__ . '/../Views/create_annuities.php';
    }

    public function update_annuity($id) {
        $valErr = $exceptionErr = "";
        
        $annuity = Annuities::find($id);
    
        if (!$annuity) {
            $exceptionErr = "Anuidade não encontrada.";
            require_once __DIR__ . '/../Views/annuities.php';
            return;
        }
    
        require_once __DIR__ . '/../Views/update_annuity.php';
    }
    
    public function refresh_annuities($data) {
        $valErr = $exceptionErr = "";
    
        $id = $data['id'];  
        $valor = $data['valor']; 
    
        if (empty($valor)) {
            $valErr = "O valor é obrigatório.";
        } else {
            try {              
                Annuities::update($id, $valor);
                
                header("Location: /annuities");
                exit();
            } catch (Exception $e) {
                $exceptionErr = "Erro ao atualizar a anuidade.";
            }
        }
    
        $annuity = Annuities::find($id); 
        require_once __DIR__ . '/../Views/update_annuity.php';
    }

    public function store_annuities($data) {
        $anoErr = $valErr = $exceptionErr = "";
        $ano = $data['ano'];
        $valor = $data['valor'];

        $anoAtual = date('Y'); 
        $anoMaximo = ($anoAtual * 1.05);

        if ($ano > $anoMaximo) {
            $anoErr = "Ano selecionado é muito superior ao ano atual.";
        }

        $existingAnnuity = Annuities::findByYear($ano);
        if ($existingAnnuity) {
            $anoErr = "Anuidade já registrada para este ano.";
        }

        $associatesExist = Associates::checkAssociatesExist($ano);
        
        if (empty($anoErr)) {
            Annuities::create([
                'ano' => $ano,
                'valor' => $valor,
            ]);
            
            if ($associatesExist) {
                Annuities::associate_annuities($ano);

                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
            else {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }

        } else {
            require_once __DIR__ . '/../Views/create_annuities.php';
        }
    }

    public function delete_annuity($data) {
        if (isset($data['id']) && !empty($data['id'])) {
            $annuityId = $data['id'];
            
            Annuities::delete($annuityId);
        }
    }
    
}
