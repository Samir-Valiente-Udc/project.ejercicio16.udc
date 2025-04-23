<?php
namespace Models\Services;

use Models\Entities\Contrato;
use Models\Repositories\ContratoRepository;

class ContratoService {
    private $repository;
    
    public function __construct() {
        $this->repository = new ContratoRepository();
    }
    
    public function getAll() {
        return $this->repository->findAll();
    }
    
    public function getById($id) {
        return $this->repository->findById($id);
    }
    
    public function getByUsuario($usuarioId) {
        return $this->repository->findByUsuario($usuarioId);
    }
    
    public function save(Contrato $contrato) {
        return $this->repository->save($contrato);
    }
    
    public function delete($id) {
        return $this->repository->delete($id);
    }
    
    public function getByStatus($estado) {
        return $this->repository->getContratosPorEstado($estado);
    }
    
    public function getByDateRange($fechaInicio, $fechaFin, $tipoBusqueda = 'firma') {
        return $this->repository->getContratosPorFecha($fechaInicio, $fechaFin, $tipoBusqueda);
    }
    
    public function getByCompany($empresa) {
        return $this->repository->getContratosPorEmpresa($empresa);
    }
    
    public function getByAmountRange($montoMin, $montoMax) {
        return $this->repository->getContratosPorRangoMonto($montoMin, $montoMax);
    }
    
    public function getContratosVencimientoProximo($diasLimite = 30) {
        $fechaHoy = date('Y-m-d');
        $fechaLimite = date('Y-m-d', strtotime("+{$diasLimite} days"));
        
        return $this->repository->getContratosPorFecha($fechaHoy, $fechaLimite, 'fin');
    }
}