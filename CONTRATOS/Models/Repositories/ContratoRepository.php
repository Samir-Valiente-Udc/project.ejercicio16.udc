<?php
namespace Models\Repositories;

use Libs\ORM\Database;
use Models\Entities\Contrato;

class ContratoRepository {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function findAll() {
        $result = $this->db->fetchAll("SELECT * FROM contratos ORDER BY fecha_firma DESC");
        $contratos = [];
        
        foreach ($result as $row) {
            $contratos[] = new Contrato($row);
        }
        
        return $contratos;
    }
    
    public function findById($id) {
        $row = $this->db->fetch("SELECT * FROM contratos WHERE id = :id", ['id' => $id]);
        
        if (!$row) {
            return null;
        }
        
        return new Contrato($row);
    }
    
    public function findByUsuario($usuarioId) {
        $result = $this->db->fetchAll(
            "SELECT * FROM contratos WHERE usuario_id = :usuario_id ORDER BY fecha_firma DESC",
            ['usuario_id' => $usuarioId]
        );
        
        $contratos = [];
        foreach ($result as $row) {
            $contratos[] = new Contrato($row);
        }
        
        return $contratos;
    }
    
    public function save(Contrato $contrato) {
        $data = [
            'fecha_firma' => $contrato->getFechaFirma(),
            'fecha_inicio' => $contrato->getFechaInicio(),
            'fecha_fin' => $contrato->getFechaFin(),
            'empresa' => $contrato->getEmpresa(),
            'empleado' => $contrato->getEmpleado(),
            'funciones' => $contrato->getFunciones(),
            'monto' => $contrato->getMonto(),
            'frecuencia_pago' => $contrato->getFrecuenciaPago(),
            'usuario_id' => $contrato->getUsuarioId()
        ];
        
        if ($contrato->getEstado()) {
            $data['estado'] = $contrato->getEstado();
        }
        
        if ($contrato->getId()) {
            // Actualización
            $data['fecha_actualizacion'] = date('Y-m-d H:i:s');
            return $this->db->update(
                'contratos',
                $data,
                'id = :id',
                ['id' => $contrato->getId()]
            );
        } else {
            // Inserción
            $id = $this->db->insert('contratos', $data);
            $contrato->setId($id);
            return $id;
        }
    }
    
    public function delete($id) {
        return $this->db->delete('contratos', 'id = :id', ['id' => $id]);
    }
    
    // Reportes
    public function getContratosPorEstado($estado) {
        $sql = "SELECT * FROM contratos WHERE estado = :estado ORDER BY fecha_inicio DESC";
        $params = ['estado' => $estado];
        
        $result = $this->db->fetchAll($sql, $params);
        
        $contratos = [];
        foreach ($result as $row) {
            $contratos[] = new Contrato($row);
        }
        
        return $contratos;
    }
    
    public function getContratosPorFecha($fechaInicio, $fechaFin, $tipoBusqueda = 'firma') {
        $campoFecha = 'fecha_firma';
        
        if ($tipoBusqueda === 'inicio') {
            $campoFecha = 'fecha_inicio';
        } else if ($tipoBusqueda === 'fin') {
            $campoFecha = 'fecha_fin';
        }
        
        $sql = "SELECT * FROM contratos WHERE {$campoFecha} BETWEEN :inicio AND :fin ORDER BY {$campoFecha}";
        $params = [
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ];
        
        $result = $this->db->fetchAll($sql, $params);
        
        $contratos = [];
        foreach ($result as $row) {
            $contratos[] = new Contrato($row);
        }
        
        return $contratos;
    }
    
    public function getContratosPorEmpresa($empresa) {
        $sql = "SELECT * FROM contratos WHERE empresa LIKE :empresa ORDER BY fecha_inicio DESC";
        $params = ['empresa' => "%{$empresa}%"];
        
        $result = $this->db->fetchAll($sql, $params);
        
        $contratos = [];
        foreach ($result as $row) {
            $contratos[] = new Contrato($row);
        }
        
        return $contratos;
    }
    
    public function getContratosPorRangoMonto($montoMin, $montoMax) {
        $sql = "SELECT * FROM contratos WHERE monto BETWEEN :min AND :max ORDER BY monto DESC";
        $params = [
            'min' => $montoMin,
            'max' => $montoMax
        ];
        
        $result = $this->db->fetchAll($sql, $params);
        
        $contratos = [];
        foreach ($result as $row) {
            $contratos[] = new Contrato($row);
        }
        
        return $contratos;
    }
}