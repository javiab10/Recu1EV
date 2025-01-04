# Recu 1 EV

Una web para manejar datos sobre restaurantes de la zona. Los usuarios podrán hacer reservas en restaurantes, los gestores podrán editar información existente o crear nuevos restaurantes, y los administradores tendrán la capacidad adicional de eliminar la información de cualquier restaurante.

## Tabla de Contenidos

- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Uso](#uso)

## Requisitos

Este proyecto requiere los siguientes componentes:

- **Apache**: Para servir la web.
- **MySQL**: Para la gestión de la base de datos.
- **XAMPP** (opcional): Para facilitar la configuración local de Apache y MySQL.
- **PHP**: Compatible con la versión usada en tu entorno de desarrollo.

## Instalación

1. **Clonar el repositorio**:
   ```bash
   git clone <URL_DEL_REPOSITORIO>
   cd <NOMBRE_DEL_DIRECTORIO>
   ```

2. **Configurar la base de datos**:
   - Localiza el archivo `config` dentro del proyecto.
   - Edita los datos de conexión para que coincidan con los de tu base de datos local.

   Ejemplo de configuración:
   ```php
   $host = 'localhost';
   $user = 'tu_usuario';
   $password = 'tu_contraseña';
   $dbname = 'nombre_base_datos';
   ```

3. **Iniciar Apache y MySQL**:
   - Abre XAMPP (u otra herramienta equivalente).
   - Activa los servicios de **Apache** y **MySQL**.

4. **Importar la base de datos**:
   - Usa phpMyAdmin (o una herramienta similar) para importar el archivo `.sql` correspondiente a la base de datos, si está disponible en el proyecto.

## Uso

1. Asegúrate de que Apache y MySQL están en funcionamiento.
2. Abre tu navegador web y navega a la URL principal del proyecto:
   ```
   http://localhost/<NOMBRE_DEL_DIRECTORIO>
   ```

### Roles del sistema

- **Usuario**: Puede explorar restaurantes y realizar reservas.
- **Gestor**: Puede editar la información de los restaurantes y crear nuevos.
- **Administrador**: Puede eliminar cualquier restaurante.

## Contribución

1. Realiza un fork del repositorio.
2. Crea una rama para tu funcionalidad:
   ```bash
   git checkout -b nueva-funcionalidad
   ```
3. Realiza tus cambios y haz commit:
   ```bash
   git commit -m "Descripción del cambio"
   ```
4. Sube tus cambios:
   ```bash
   git push origin nueva-funcionalidad
   ```
5. Abre un Pull Request en GitHub.
