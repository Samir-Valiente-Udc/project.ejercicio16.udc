<?php
namespace Controllers;

use Models\Services\UsuarioService;
use Models\Entities\Usuario;
use Utils\Session;
use Utils\Validator;

class UsuarioController {
    private $service;
    
    public function __construct() {
        $this->service = new UsuarioService();
        Session::requireLogin();
    }
    
    public function index() {
        $usuarios = $this->service->getAll();
        include 'Views/forms/usuarios/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            $validator->required('username', 'El nombre de usuario es obligatorio')
                     ->required('password', 'La contraseña es obligatoria')
                     ->minLength('password', 8, 'La contraseña debe tener al menos 8 caracteres')
                     ->required('nombre', 'El nombre es obligatorio')
                     ->required('email', 'El email es obligatorio')
                     ->email('email', 'Ingrese un email válido');
            
            if ($validator->isValid()) {
                $usuario = new Usuario($_POST);
                $this->service->save($usuario);
                
                Session::setFlash('success', 'Usuario creado correctamente');
                header('Location: usuarios.php');
                exit;
            } else {
                Session::setFlash('errors', $validator->getErrors());
            }
        }
        
        include 'Views/forms/usuarios/create.php';
    }
    
    public function edit($id) {
        $usuario = $this->service->getById($id);
        
        if (!$usuario) {
            Session::setFlash('error', 'Usuario no encontrado');
            header('Location: usuarios.php');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            $validator->required('username', 'El nombre de usuario es obligatorio')
                     ->required('nombre', 'El nombre es obligatorio')
                     ->required('email', 'El email es obligatorio')
                     ->email('email', 'Ingrese un email válido');
            
            // Si se proporcionó contraseña, validarla
            if (!empty($_POST['password'])) {
                $validator->minLength('password', 8, 'La contraseña debe tener al menos 8 caracteres');
            }
            
            if ($validator->isValid()) {
                $usuario->setUsername($_POST['username']);
                $usuario->setNombre($_POST['nombre']);
                $usuario->setEmail($_POST['email']);
                
                if (!empty($_POST['password'])) {
                    $usuario->setPassword($_POST['password']);
                }
                
                if (isset($_POST['estado'])) {
                    $usuario->setEstado($_POST['estado']);
                }
                
                $this->service->save($usuario);
                
                Session::setFlash('success', 'Usuario actualizado correctamente');
                header('Location: usuarios.php');
                exit;
            } else {
                Session::setFlash('errors', $validator->getErrors());
            }
        }
        
        include 'Views/forms/usuarios/edit.php';
    }
    
    public function delete($id) {
        $usuario = $this->service->getById($id);
        
        if (!$usuario) {
            Session::setFlash('error', 'Usuario no encontrado');
        } else {
            $this->service->delete($id);
            Session::setFlash('success', 'Usuario eliminado correctamente');
        }
        
        header('Location: usuarios.php');
        exit;
    }
    
    public function reportByStatus() {
        $estado = $_GET['estado'] ?? 'activo';
        $usuarios = $this->service->getUsersByStatus($estado);
        
        include 'Views/forms/usuarios/report_status.php';
    }
    
    public function reportByDate() {
        $fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-d', strtotime('-30 days'));
        $fechaFin = $_GET['fecha_fin'] ?? date('Y-m-d');
        
        $usuarios = $this->service->getUsersByRegistrationDate($fechaInicio, $fechaFin);
        
        include 'Views/forms/usuarios/report_date.php';
    }
}