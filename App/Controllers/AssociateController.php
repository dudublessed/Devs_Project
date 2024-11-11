<?php
namespace App\Controllers;

use App\Models\Associates;
use App\Models\Annuities;
use App\Models\AssociatedAnnuities;
use PDOException;
use Exception;


class AssociateController {

    public function index() {
        require_once __DIR__ . '/../Views/home.php';
    }

    public function show_associates() {
        $associates = Associates::all();
        extract(['associates' => $associates]); 
        require_once __DIR__ . '/../Views/associates.php';
    }

    public function create_associates() {
        $nomeErr = $emailErr = $cpfErr = $dataFiliacaoErr = $exceptionErr = "";

        require_once __DIR__ . '/../Views/create_associates.php';
    }

    public function store_associated($data) {
        $nomeErr = $emailErr = $cpfErr = $dataFiliacaoErr = $exceptionErr = "";
        $nome = $email = $cpf = $data_filiacao = "";

        if (empty($data['nome'])) {
            $nomeErr = "O nome é obrigatório";
        } else {
            $nome = $this->sanitize_input($data['nome']);
            if (!preg_match("/^[a-zA-ZÀ-ÿ ]*$/", $nome)) {
                $nomeErr = "Apenas letras e espaços são permitidos";
            }
        }

        if (empty($data['email'])) {
            $emailErr = "O e-mail é obrigatório";
        } else {
            $email = $this->sanitize_input($data['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Formato de e-mail inválido";
            } else {
                $existingEmail = Associates::findByEmail($email); 
                if ($existingEmail) {
                    $emailErr = "O e-mail já está registrado.";
                }
            }
        }
        
        if (empty($data['cpf'])) {
            $cpfErr = "O CPF é obrigatório";
        } else {
            $cpf = $this->sanitize_input($data['cpf']);
            if (!preg_match("/^\d{11}$/", $cpf)) {
                $cpfErr = "CPF inválido. Deve conter 11 dígitos";
            }
        }

        if (!isset($data['data_filiacao']) || empty($data['data_filiacao'])) {
            $dataFiliacaoErr = "A data de filiação é obrigatória";
        } else {
            $data_filiacao = $this->sanitize_input($data['data_filiacao']);

            if (date('Y', strtotime($data_filiacao)) > date('Y')) {
                $dataFiliacaoErr = "Data de filiação inválida. Não pode ser em ano futuro.";
            }
        }
        

        if (empty($nomeErr) && empty($emailErr) && empty($cpfErr) && empty($dataFiliacaoErr)) {
            try {
                Associates::create([
                    'nome' => $nome,
                    'email' => $email,
                    'cpf' => $cpf,
                    'data_filiacao' => $data_filiacao
                ]);

            $associateId = Associates::findByEmail($email)['id'];

            $ano_filiacao = date('Y', strtotime($data_filiacao));
            $annuities = Annuities::findAnnuitiesByYear($ano_filiacao);

            /*
            if (empty($annuities)) {
                $exceptionErr = "Não há anuidades registradas para o ano de filiação ou posteriores.";
                require_once __DIR__ . '/../Views/create_associates.php';
                return;
            } */
            
            foreach ($annuities as $annuity) {
                if ($annuity['ano'] >= $ano_filiacao) {
                    AssociatedAnnuities::associateAnnuityToAssociate($associateId, $annuity['id']);
                }
            }

            header("Location: /associates");
            exit();

            } catch (PDOException $e) {
                $exceptionErr = "Erro ao cadastrar associado. Tente novamente. ";
            }
        } else {
            require_once __DIR__ . '/../Views/create_associates.php';
        }
    }

    public function delete_associated($data) {
        if (isset($data['id']) && !empty($data['id'])) {
            $associateId = $data['id'];
            
            Associates::delete($associateId);
        }
    }

    public function update_associated($id) {
        $nomeErr = $emailErr = $cpfErr = $dataFiliacaoErr = $exceptionErr = "";
        
        $associated = Associates::find($id);
    
        if (!$associated) {
            $exceptionErr = "Associado não encontrada.";
            require_once __DIR__ . '/../Views/associates.php';
            return;
        }
    
        require_once __DIR__ . '/../Views/update_associated.php';

    }

    public function refresh_associated($data) {
        $nomeErr = $emailErr = $cpfErr = $dataFiliacaoErr = $exceptionErr = "";
    
        $id = $data['id'];  
        $nome = $data['nome']; 
        $email = $data['email']; 
        $cpf = $data['cpf']; 
        $data_filiacao = $data['data_filiacao']; 

        if (empty($data['nome'])) {
            $nomeErr = "O nome é obrigatório";
        } else {
            $nome = $this->sanitize_input($data['nome']);
            if (!preg_match("/^[a-zA-ZÀ-ÿ ]*$/", $nome)) {
                $nomeErr = "Apenas letras e espaços são permitidos";
            }
        }

        if (empty($data['email'])) {
            $emailErr = "O e-mail é obrigatório";
        } else {
            $email = $this->sanitize_input($data['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Formato de e-mail inválido";
            } 
        }
        
        if (empty($data['cpf'])) {
            $cpfErr = "O CPF é obrigatório";
        } else {
            $cpf = $this->sanitize_input($data['cpf']);
            if (!preg_match("/^\d{11}$/", $cpf)) {
                $cpfErr = "CPF inválido. Deve conter 11 dígitos";
            }
        }

        if (!isset($data['data_filiacao']) || empty($data['data_filiacao'])) {
            $dataFiliacaoErr = "A data de filiação é obrigatória";
        } else {
            $data_filiacao = $this->sanitize_input($data['data_filiacao']);

            if (date('Y', strtotime($data_filiacao)) > date('Y')) {
                $dataFiliacaoErr = "Data de filiação inválida. Não pode ser em ano futuro.";
            }
        }
    
        if (empty($nomeErr) && empty($emailErr) && empty($cpfErr) && empty($dataFiliacaoErr)) {
            try {              
                Associates::update($id, $nome, $email, $cpf, $data_filiacao);
                    
                header("Location: /associates");
                exit();
            } catch (Exception $e) {
                $exceptionErr = "Erro ao atualizar associado. ";
            }
        }
    
        $associated = Associates::find($id); 
        require_once __DIR__ . '/../Views/update_associated.php';
    }

    private function sanitize_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}
