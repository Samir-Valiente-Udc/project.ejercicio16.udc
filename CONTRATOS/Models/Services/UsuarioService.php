<?php
namespace Models\Services;

use Models\Entities\Usuario;
use Models\Repositories\UsuarioRepository;
use Utils\Email;

class UsuarioService {
    private $repository;
    
    public function __construct() {
        $this->repository = new UsuarioRepository();
    }
    
    public function getAll() {
        return $this->repository->findAll();
    }
    
    public function getById($id) {
        return $this->repository->findById($id);
    }
    
    public function save(Usuario $usuario) {
        return $this->repository->save($usuario);
    }
    
    public function delete($id) {
        return $this->repository->delete($id);
    }
    
    public function authenticate($username, $password) {
        $usuario = $this->repository->findByUsername($username);
        
        if (!$usuario) {
            return false;
        }
        
        if (!$usuario->verificarPassword($password)) {
            return false;
        }
        
        // Actualizar el último acceso
        $this->repository->updateLastLogin($usuario->getId());
        
        return $usuario;
    }
    
    public function generatePasswordResetToken($email) {
        $usuario = $this->repository->findByEmail($email);
        
        if (!$usuario) {
            return false;
        }
        
        // Generar token único
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        $usuario->setResetToken($token);
        $usuario->setResetTokenExpiry($expiry);
        
        $this->repository->save($usuario);
        
        // Enviar email
        $emailSender = new Email();
        $resetUrl = "http://{$_SERVER['HTTP_HOST']}/reset_password.php?token={$token}";
        
        $subject = "Recuperación de contraseña";
        $message = "Hola {$usuario->getNombre()},\n\n";
        $message .= "Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace para crear una nueva contraseña:\n\n";
        $message .= $resetUrl . "\n\n";
        $message .= "Este enlace es válido por 24 horas.\n\n";
        $message .= "Si no solicitaste restablecer tu contraseña, puedes ignorar este mensaje.\n\n";
        $message .= "Saludos,\nSistema de Contratos";
        
        return $emailSender->send($usuario->getEmail(), $subject, $message);
    }
    
    public function resetPassword($token, $password) {
        $usuario = $this->repository->findByResetToken($token);
        
        if (!$usuario) {
            return false;
        }
        
        $usuario->setPassword($password);
        $usuario->setResetToken(null);
        $usuario->setResetTokenExpiry(null);
        
        $this->repository->save($usuario);
        return true;
    }
    
    public function getUsersByStatus($estado) {
        return $this->repository->getUsuariosPorEstado($estado);
    }
    
    public function getUsersByRegistrationDate($fechaInicio, $fechaFin) {
        return $this->repository->getUsuariosPorFechaRegistro($fechaInicio, $fechaFin);
    }
}