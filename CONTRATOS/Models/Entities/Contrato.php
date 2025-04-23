<?php
namespace Models\Entities;

class Contrato {
    private $id;                                            // ? int|null ID del contrato (autoincremental)
    private $fecha_firma;
    private $fecha_inicio;
    private $fecha_fin;
    private $empresa;
    private $empleado;
    private $funciones;
    private $monto;
    private $frecuencia_pago;
    private $usuario_id;
    private $estado;
    private $fecha_creacion;
    private $fecha_actualizacion;

    public function __construct($data = null) {
        if ($data) {
            $this->hydrate($data);
        }
    }

    public function hydrate($data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters y Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getFechaFirma() {
        return $this->fecha_firma;
    }

    public function setFechaFirma($fecha_firma) {
        $this->fecha_firma = $fecha_firma;
        return $this;
    }

    public function getFechaInicio() {
        return $this->fecha_inicio;
    }

    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
        return $this;
    }

    public function getFechaFin() {
        return $this->fecha_fin;
    }

    public function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
        return $this;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function setEmpresa($empresa) {
        $this->empresa = $empresa;
        return $this;
    }

    public function getEmpleado() {
        return $this->empleado;
    }

    public function setEmpleado($empleado) {
        $this->empleado = $empleado;
        return $this;
    }

    public function getFunciones() {
        return $this->funciones;
    }

    public function setFunciones($funciones) {
        $this->funciones = $funciones;
        return $this;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
        return $this;
    }

    public function getFrecuenciaPago() {
        return $this->frecuencia_pago;
    }

    public function setFrecuenciaPago($frecuencia_pago) {
        $this->frecuencia_pago = $frecuencia_pago;
        return $this;
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
        return $this;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
        return $this;
    }

    public function getFechaCreacion() {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
        return $this;
    }

    public function getFechaActualizacion() {
        return $this->fecha_actualizacion;
    }

    public function setFechaActualizacion($fecha_actualizacion) {
        $this->fecha_actualizacion = $fecha_actualizacion;
        return $this;
    }

    public function getDuracionMeses() {
        $inicio = new \DateTime($this->fecha_inicio);
        $fin = new \DateTime($this->fecha_fin);
        $diferencia = $inicio->diff($fin);
        return ($diferencia->y * 12) + $diferencia->m;
    }

    public function estaVigente() {
        return $this->estado === 'vigente';
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'fecha_firma' => $this->fecha_firma,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'empresa' => $this->empresa,
            'empleado' => $this->empleado,
            'funciones' => $this->funciones,
            'monto' => $this->monto,
            'frecuencia_pago' => $this->frecuencia_pago,
            'usuario_id' => $this->usuario_id,
            'estado' => $this->estado,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_actualizacion' => $this->fecha_actualizacion
        ];
    }
}