<?php
namespace Controllers;

use Models\Services\UsuarioService;
use Models\Entities\Usuario;
use Utils\Session;
use Utils\Validator;

class AuthController {
    private $service;
    
    public function __construct() {
        $this->service = new UsuarioService();
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $validator = new Validator($_POST);
            $validator->required('username', 'El nombre de usuario es obligatorio')
                     ->required('password', 'La contraseña es obligatoria');
            
            if ($validator->isValid()) {
                $usuario = $this->service->authenticate($username, $password);
                
                if ($usuario) {
                    Session::set('user_id', $usuario->getId());
                    Session::set('username', $usuario->getUsername());
                    Session::set('nombre', $usuario->getNombre());
                    
                    Session::setFlash('success', 'Inicio de sesión exitoso');
                    header('Location: index.php');
                    exit;
                } else {
                    Session::setFlash('error', 'Nombre de usuario o contraseña incorrectos');
                }
            } else {
                Session::setFlash('errors', $validator->getErrors());
            }
        }
        
        // Mostrar formulario de login
        include 'Views/forms/login.php';
    }
    
    public function logout() {
        Session::destroy();
        Session::setFlash('success', 'Sesión cerrada correctamente');
        header('Location: login.php');
        exit;
    }
    
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            $validator = new Validator($_POST);
            $validator->required('email', 'El email es obligatorio')
                     ->email('email', 'Ingrese un email válido');
            
            if ($validator->isValid()) {
                $success = $this->service->generatePasswordResetToken($email);
                
                if ($success) {
                    Session::setFlash('success', 'Se ha enviado un correo con instrucciones para restablecer tu contraseña');
                } else {
                    Session::setFlash('error', 'No se encontró ninguna cuenta con ese email');
                }
            } else {
                Session::setFlash('errors', $validator->getErrors());
            }
        }
        
        // Mostrar formulario de recuperación de contraseña
        include 'Views/forms/forgot_password.php';
    }
    
    public function resetPassword() {
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            Session::setFlash('error', 'Token inválido');
            header('Location: login.php');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            $validator = new Validator($_POST);
            $validator->required('password', 'La contraseña es obligatoria')
                     ->minLength('password', 8, 'La contraseña debe tener al menos 8 caracteres')
                     ->required('confirm_password', 'Debe confirmar la contraseña')
                     ->custom('confirm_password', function($value) use ($password) {
                         return $value === $password;
                     }, 'Las contraseñas no coinciden');
            
            if ($validator->isValid()) {
                $success = $this->service->resetPassword($token, $password);
                
                if ($success) {
                    Session::setFlash('success', 'Contraseña actualizada correctamente. Ya puedes iniciar sesión.');
                    header('Location: login.php');
                    exit;
                } else {
                    Session::setFlash('error', 'El enlace de restablecimiento no es válido o ha expirado');
                }
            } else {
                Session::setFlash('errors', $validator->getErrors());
            }
        }
        
        // Mostrar formulario de reseteo de contraseña
        include 'Views/forms/reset_password.php';
    }
}