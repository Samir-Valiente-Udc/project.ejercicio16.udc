# Sistema de Gestión de Contratos
> Proyecto de gestión de contratos universitarios

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

1. **Habilitar mod_rewrite**
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

2. **Configurar Apache**
````apache
<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
````

## 🔑 Credenciales por defecto

- **Usuario:** admin
- **Contraseña:** admin123

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

## 👥 Contribución

1. Fork del proyecto
2. Crear rama feature (`git checkout -b feature/AmazingFeature`)
3. Commit cambios (`git commit -m 'Add: nueva característica'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Crear Pull Request

## ⚠️ Solución de Problemas

1. **Error 404**
   - Verificar .htaccess
   - Comprobar mod_rewrite
   - Revisar permisos

2. **Error de conexión DB**
   - Verificar credenciales
   - Comprobar servicio MySQL

## 📞 Soporte

Para soporte contactar a:
- Email: soporte@ejemplo.com
- Issues: GitHub Issues

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo LICENSE.md para detalles.