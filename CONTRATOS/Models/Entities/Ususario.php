<?php
// Definición del namespace para organizar la clase en la estructura de la aplicación
namespace Models\Entities;

/* 
 * Clase Usuario - Representa la entidad de usuario en el sistema
 * 
 * Maneja las propiedades y comportamientos relacionados con un usuario,
 * incluyendo autenticación, hidratación y transformación de datos.
 */
class Usuario {
    // Propiedades privadas para encapsular los datos del usuario
    
    private $id;                    //? int|null ID del usuario (autoincremental)
    private $username;              //? string Nombre de usuario (único)
    private $password;              //? string Contraseña hasheada del usuario
    private $nombre;                //? string Nombre completo del usuario
    private $email;                 //? string Email del usuario (único)
    private $fecha_registro;        //? string Fecha de registro (formato datetime)
    private $ultimo_acceso;         //? string|null Fecha del último acceso (formato datetime)
    private $estado;                //? int Estado del usuario (0: inactivo, 1: activo)
    private $reset_token;           //? string|null Token para restablecer contraseña
    private $reset_token_expiry;    //? string|null Fecha de expiración del token (formato datetime)

    
    /*
     ? Constructor de la clase Usuario
     * array|null $data Datos iniciales para hidratar el objeto
    */
    public function __construct($data = null) {
      
        // Si se proporcionan datos, hidratar el objeto
        if ($data) {
            $this->hydrate($data);
        }
    }

    /*
     ? Método de hidratación - Asigna valores a las propiedades basado en un array
     * array $data Array asociativo con los datos del usuario
    */
    public function hydrate($data) {
        foreach ($data as $key => $value) {

            //? Construye el nombre del método setter (ej: 'username' -> 'setUsername')
            $method = 'set' . ucfirst($key);
            
            //? Verifica si el método setter existe antes de llamarlo
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    //! ============= GETTERS & SETTERS =============

    /*
     ? Obtiene el ID del usuario
     * int|null
    */
    public function getId() {
        return $this->id;
    }

    /*
     ? Establece el ID del usuario
     * >> int $id
     * << self
    */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /*
     ? Obtiene el nombre de usuario
     * << string
    */
    public function getUsername() {
        return $this->username;
    }

    /*
     ? Establece el nombre de usuario
     * >> string $username
     * << self
    */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /*
     ? Obtiene la contraseña hasheada
     * << string
    */
    public function getPassword() {
        return $this->password;
    }

    /*
     ? Establece la contraseña, aplicando hash si no está hasheada
     * >> string $password
     * << self
    */
    public function setPassword($password) {
        // Solo aplica hash si la contraseña no está vacía y no parece estar ya hasheada
        if (!empty($password) && strlen($password) < 60) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $this->password = $password;
        }
        return $this;
    }

    /*
     ? Obtiene el nombre completo
     * << string
    */
    public function getNombre() {
        return $this->nombre;
    }

    /*
     ? Establece el nombre completo
     * >> string $nombre
     * << self
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    /*
     ? Obtiene el email
     * << string
     */
    public function getEmail() {
        return $this->email;
    }

    /*
     ? Establece el email
     * >> string $email
     * << self
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /*
     ? Obtiene la fecha de registro
     * << string
     */
    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

    /*
     ? Establece la fecha de registro
     * >> string $fecha_registro
     * << self
     */
    public function setFechaRegistro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
        return $this;
    }

    /*
     ? Obtiene la fecha del último acceso
     * << string|null
     */
    public function getUltimoAcceso() {
        return $this->ultimo_acceso;
    }

    /*
     ? Establece la fecha del último acceso
     * >> string|null $ultimo_acceso
     * << self
     */
    public function setUltimoAcceso($ultimo_acceso) {
        $this->ultimo_acceso = $ultimo_acceso;
        return $this;
    }

    /*
     ? Obtiene el estado del usuario
     * << int
     */
    public function getEstado() {
        return $this->estado;
    }

    /*
     ? Establece el estado del usuario
     * >> int $estado
     * << self
     */
    public function setEstado($estado) {
        $this->estado = $estado;
        return $this;
    }

    /*
     ? Obtiene el token para restablecer contraseña
     * << string|null
     */
    public function getResetToken() {
        return $this->reset_token;
    }

    /*
     ? Establece el token para restablecer contraseña
     * >> string|null $reset_token
     * << self
     */
    public function setResetToken($reset_token) {
        $this->reset_token = $reset_token;
        return $this;
    }

    /*
     ? Obtiene la fecha de expiración del token
     * << string|null
     */
    public function getResetTokenExpiry() {
        return $this->reset_token_expiry;
    }

    /*
     ? Establece la fecha de expiración del token
     * >> string|null $reset_token_expiry
     * << self
     */
    public function setResetTokenExpiry($reset_token_expiry) {
        $this->reset_token_expiry = $reset_token_expiry;
        return $this;
    }

    //! ============= MÉTODOS FUNCIONALES =============

    /*
     ? Verifica si una contraseña coincide con el hash almacenado
     * >> string $password Contraseña a verificar
     * << bool True si la contraseña es correcta, false en caso contrario
     */
    public function verificarPassword($password) {
        return password_verify($password, $this->password);
    }

    /*
     ? Convierte el objeto a array, excluyendo datos sensibles
     * << array Representación segura del usuario para mostar/exportar
     */
    public function toArray() {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'fecha_registro' => $this->fecha_registro,
            'ultimo_acceso' => $this->ultimo_acceso,
            'estado' => $this->estado
        ];
    }
}