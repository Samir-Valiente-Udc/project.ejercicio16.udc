<?php
namespace Models\Repositories;

use Libs\ORM\Database;
use Models\Entities\Usuario;

class UsuarioRepository {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function findAll() {
        $result = $this->db->fetchAll("SELECT * FROM usuarios ORDER BY id");
        $usuarios = [];
        
        foreach ($result as $row) {
            $usuarios[] = new Usuario($row);
        }
        
        return $usuarios;
    }
    
    public function findById($id) {
        $row = $this->db->fetch("SELECT * FROM usuarios WHERE id = :id", ['id' => $id]);
        
        if (!$row) {
            return null;
        }
        
        return new Usuario($row);
    }
    
    public function findByUsername($username) {
        $row = $this->db->fetch("SELECT * FROM usuarios WHERE username = :username", ['username' => $username]);
        
        if (!$row) {
            return null;
        }
        
        return new Usuario($row);
    }
    
    public function findByEmail($email) {
        $row = $this->db->fetch("SELECT * FROM usuarios WHERE email = :email", ['email' => $email]);
        
        if (!$row) {
            return null;
        }
        
        return new Usuario($row);
    }
    
    public function findByResetToken($token) {
        $row = $this->db->fetch(
            "SELECT * FROM usuarios WHERE reset_token = :token AND reset_token_expiry > NOW()",
            ['token' => $token]
        );
        
        if (!$row) {
            return null;
        }
        
        return new Usuario($row);
    }
    
    public function save(Usuario $usuario) {
        $data = [
            'username' => $usuario->getUsername(),
            'password' => $usuario->getPassword(),
            'nombre' => $usuario->getNombre(),
            'email' => $usuario->getEmail()
        ];
        
        if ($usuario->getEstado()) {
            $data['estado'] = $usuario->getEstado();
        }
        
        if ($usuario->getResetToken()) {
            $data['reset_token'] = $usuario->getResetToken();
            $data['reset_token_expiry'] = $usuario->getResetTokenExpiry();
        }
        
        if ($usuario->getId()) {
            // Actualización
            return $this->db->update(
                'usuarios',
                $data,
                'id = :id',
                ['id' => $usuario->getId()]
            );
        } else {
            // Inserción
            $id = $this->db->insert('usuarios', $data);
            $usuario->setId($id);
            return $id;
        }
    }
    
    public function delete($id) {
        return $this->db->delete('usuarios', 'id = :id', ['id' => $id]);
    }
    
    public function updateLastLogin($id) {
        return $this->db->update(
            'usuarios',
            ['ultimo_acceso' => date('Y-m-d H:i:s')],
            'id = :id',
            ['id' => $id]
        );
    }
    
    // Reportes
    public function getUsuariosPorEstado($estado = null) {
        $sql = "SELECT * FROM usuarios";
        $params = [];
        
        if ($estado) {
            $sql .= " WHERE estado = :estado";
            $params['estado'] = $estado;
        }
        
        $sql .= " ORDER BY nombre";
        $result = $this->db->fetchAll($sql, $params);
        
        $usuarios = [];
        foreach ($result as $row) {
            $usuarios[] = new Usuario($row);
        }
        
        return $usuarios;
    }
    
    public function getUsuariosPorFechaRegistro($fechaInicio, $fechaFin) {
        $sql = "SELECT * FROM usuarios WHERE fecha_registro BETWEEN :inicio AND :fin ORDER BY fecha_registro";
        $params = [
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ];
        
        $result = $this->db->fetchAll($sql, $params);
        
        $usuarios = [];
        foreach ($result as $row) {
            $usuarios[] = new Usuario($row);
        }
        
        return $usuarios;
    }
}