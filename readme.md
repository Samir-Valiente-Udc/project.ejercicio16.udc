# Sistema de Gestión de Contratos
> Proyecto de gestión de contratos 

## 📋 Requisitos Previos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache2
- Módulos PHP:
  - PDO
  - PDO_MySQL
  - session

## 🚀 Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/Samir-Valiente-Udc/project.ejercicio16.udc.git
cd project.ejercicio16.udc
```

2. **Configurar la base de datos**
```bash
mysql -u root -p < database.sql
```

3. **Configurar credenciales de base de datos**
````php
<?php
return [
    'host' => 'localhost',
    'dbname' => 'sistema_contratos',
    'user' => 'estudiante',
    'password' => 'AbcdeUdeC'
];
````

4. **Configurar Apache**
```bash
sudo ln -s /ruta/completa/project.ejercicio16.udc /var/www/html/
sudo chown -R www-data:www-data /var/www/html/project.ejercicio16.udc
sudo chmod -R 755 /var/www/html/project.ejercicio16.udc
```

## 📁 Estructura del Proyecto

```
project.ejercicio16.udc/
├── index.php                 # Punto de entrada
├── .htaccess                # Configuración Apache
└── CONTRATOS/
    ├── Config/              # Configuraciones
    ├── Controllers/         # Controladores
    ├── Models/              # Modelos
    ├── Views/               # Vistas
    └── Libs/                # Librerías
```

## ⚙️ Configuración

1. **Configurar Apache**
````apache
<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
````

## 🛠️ Funcionalidades

- Gestión de contratos
- Control de usuarios
- Reportes y estadísticas
- Panel administrativo

## 📝 Logs y Depuración

```bash
# Ver logs de Apache
sudo tail -f /var/log/apache2/error.log
```

## 🔒 Seguridad

- Autenticación de usuarios
- Validación de formularios
- Protección contra SQL Injection
- Manejo de sesiones seguras