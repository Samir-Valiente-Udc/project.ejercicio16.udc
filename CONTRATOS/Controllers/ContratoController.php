<?php
namespace Controllers;

use Models\Services\ContratoService;
use Models\Entities\Contrato;
use Utils\Session;
use Utils\Validator;

class ContratoController {
    private $service;
    
    public function __construct() {
        $this->service = new ContratoService();
        Session::requireLogin();
    }
    
    public function index() {
        $contratos = $this->service->getAll();
        include 'Views/forms/contratos/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            $validator->required('fecha_firma', 'La fecha de firma es obligatoria')
                     ->date('fecha_firma', 'Y-m-d', 'La fecha de firma debe tener formato YYYY-MM-DD')
                     ->required('fecha_inicio', 'La fecha de inicio es obligatoria')
                     ->date('fecha_inicio', 'Y-m-d', 'La fecha de inicio debe tener formato YYYY-MM-DD')
                     ->required('fecha_fin', 'La fecha de fin es obligatoria')
                     ->date('fecha_fin', 'Y-m-d', 'La fecha de fin debe tener formato YYYY-MM-DD')
                     ->required('empresa', 'La empresa es obligatoria')
                     ->required('empleado', 'El empleado es obligatorio')
                     ->required('funciones', 'Las funciones son obligatorias')
                     ->required('monto', 'El monto es obligatorio')
                     ->numeric('monto', 'El monto debe ser un valor numérico')
                     ->required('frecuencia_pago', 'La frecuencia de pago es obligatoria')
                     ->required('usuario_id', 'El usuario es obligatorio');
            
            if ($validator->isValid()) {
                $contrato = new Contrato($_POST);
                $this->service->save($contrato);
                
                Session::setFlash('success', 'Contrato creado correctamente');
                header('Location: contratos.php');
                exit;
            } else {
                Session::setFlash('errors', $validator->getErrors());
            }
        }
        
        include 'Views/forms/contratos/create.php';
    }
    
    public function edit($id) {
        $contrato = $this->service->getById($id);
        
        if (!$contrato) {
            Session::setFlash('error', 'Contrato no encontrado');
            header('Location: contratos.php');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            $validator->required('fecha_firma', 'La fecha de firma es obligatoria')
                     ->date('fecha_firma', 'Y-m-d', 'La fecha de firma debe tener formato YYYY-MM-DD')
                     ->required('fecha_inicio', 'La fecha de inicio es obligatoria')
                     ->date('fecha_inicio', 'Y-m-d', 'La fecha de inicio debe tener formato YYYY-MM-DD')
                     ->required('fecha_fin', 'La fecha de fin es obligatoria')
                     ->date('fecha_fin', 'Y-m-d', 'La fecha de fin debe tener formato YYYY-MM-DD')
                     ->required('empresa', 'La empresa es obligatoria')
                     ->required('empleado', 'El empleado es obligatorio')
                     ->required('funciones', 'Las funciones son obligatorias')
                     ->required('monto', 'El monto es obligatorio')
                     ->numeric('monto', 'El monto debe ser un valor numérico')
                     ->required('frecuencia_pago', 'La frecuencia de pago es obligatoria')
                     ->required('usuario_id', 'El usuario es obligatorio');
            
            if ($validator->isValid()) {
                $contrato->hydrate($_POST);
                $this->service->save($contrato);
                
                Session::setFlash('success', 'Contrato actualizado correctamente');
                header('Location: contratos.php');
                exit;
            } else {
                Session::setFlash('errors', $validator->getErrors());
            }
        }
        
        include 'Views/forms/contratos/edit.php';
    }
    
    public function delete($id) {
        $contrato = $this->service->getById($id);
        
        if (!$contrato) {
            Session::setFlash('error', 'Contrato no encontrado');
        } else {
            $this->service->delete($id);
            Session::setFlash('success', 'Contrato eliminado correctamente');
        }
        
        header('Location: contratos.php');
        exit;
    }
    
    public function reportByStatus() {
        $estado = $_GET['estado'] ?? 'vigente';
        $contratos = $this->service->getByStatus($estado);
        
        include 'Views/forms/contratos/report_status.php';
    }
    
    public function reportByDateRange() {
        $fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-d', strtotime('-30 days'));
        $fechaFin = $_GET['fecha_fin'] ?? date('Y-m-d');
        $tipoBusqueda = $_GET['tipo_busqueda'] ?? 'firma';
        
        $contratos = $this->service->getByDateRange($fechaInicio, $fechaFin, $tipoBusqueda);
        
        include 'Views/forms/contratos/report_date.php';
    }
    
    public function reportByCompany() {
        $empresa = $_GET['empresa'] ?? '';
        $contratos = $this->service->getByCompany($empresa);
        
        include 'Views/forms/contratos/report_company.php';
    }
    
    public function reportByAmountRange() {
        $montoMin = $_GET['monto_min'] ?? 0;
        $montoMax = $_GET['monto_max'] ?? 10000;
        
        $contratos = $this->service->getByAmountRange($montoMin, $montoMax);
        
        include 'Views/forms/contratos/report_amount.php';
    }
}