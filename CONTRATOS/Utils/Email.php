<?php
namespace Utils;

class Email {
    private $mailer;
    private $from = 'sistema@contratos.com';
    private $fromName = 'Sistema de Contratos';
    
    public function __construct() {
        // En un entorno real, aquí se configuraría PHPMailer, Swift Mailer, etc.
        // Para este ejemplo, simularemos el envío de correos
    }
    
    public function send($to, $subject, $body, $isHtml = false) {
        // En un entorno real, esta función enviaría el correo electrónico
        // Para este ejemplo, simularemos que el correo se envió correctamente
        
        // Registro del correo para depuración
        $logFile = __DIR__ . '/../logs/emails.log';
        $logDir = dirname($logFile);
        
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $logEntry = date('Y-m-d H:i:s') . " - To: {$to} - Subject: {$subject} - Body: " . substr($body, 0, 100) . "...\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
        
        return true;
    }
}