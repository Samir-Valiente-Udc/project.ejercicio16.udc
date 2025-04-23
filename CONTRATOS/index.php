<?php
require_once 'CONTRATOS/Config/database.php';

class ContratoController {
    public function index() {
        echo "ContratoController index method called.";
    }
}

// Iniciar el controlador principal
$controller = new ContratoController();
$controller->index();