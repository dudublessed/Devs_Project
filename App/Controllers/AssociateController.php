<?php
namespace App\Controllers;

use App\Models\Associates;

class AssociateController {
    public function index() {
        $users = Associates::all();
        
        require_once __DIR__ . '/../Views/home.php';
    }

    public function create() {
        require_once __DIR__ . '/../Views/create_associates.php';
    }

    public function store($data) {
        Associates::create($data);


        header('Location: /devs_rn/associates');
        exit();
    }
}
