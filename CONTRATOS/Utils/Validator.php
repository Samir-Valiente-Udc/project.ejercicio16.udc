<?php
namespace Utils;

class Validator {
    private $errors = [];
    private $data = [];
    
    public function __construct($data = []) {
        $this->data = $data;
    }
    
    public function setData($data) {
        $this->data = $data;
        return $this;
    }
    
    public function required($field, $message = null) {
        if (!isset($this->data[$field]) || trim($this->data[$field]) === '') {
            $this->errors[$field] = $message ?: "El campo {$field} es obligatorio";
        }
        return $this;
    }
    
    public function email($field, $message = null) {
        if (isset($this->data[$field]) && trim($this->data[$field]) !== '' && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?: "El campo {$field} debe ser un email válido";
        }
        return $this;
    }
    
    public function minLength($field, $length, $message = null) {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field] = $message ?: "El campo {$field} debe tener al menos {$length} caracteres";
        }
        return $this;
    }
    
    public function maxLength($field, $length, $message = null) {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->errors[$field] = $message ?: "El campo {$field} debe tener como máximo {$length} caracteres";
        }
        return $this;
    }
    
    public function numeric($field, $message = null) {
        if (isset($this->data[$field]) && trim($this->data[$field]) !== '' && !is_numeric($this->data[$field])) {
            $this->errors[$field] = $message ?: "El campo {$field} debe ser numérico";
        }
        return $this;
    }
    
    public function date($field, $format = 'Y-m-d', $message = null) {
        if (isset($this->data[$field]) && trim($this->data[$field]) !== '') {
            $dateTime = \DateTime::createFromFormat($format, $this->data[$field]);
            if (!$dateTime || $dateTime->format($format) !== $this->data[$field]) {
                $this->errors[$field] = $message ?: "El campo {$field} debe ser una fecha válida con formato {$format}";
            }
        }
        return $this;
    }
    
    public function custom($field, $callback, $message = null) {
        if (isset($this->data[$field]) && !$callback($this->data[$field])) {
            $this->errors[$field] = $message ?: "El campo {$field} no es válido";
        }
        return $this;
    }
    
    public function isValid() {
        return empty($this->errors);
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function getError($field) {
        return isset($this->errors[$field]) ? $this->errors[$field] : null;
    }
}