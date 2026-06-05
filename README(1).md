
#API Keys  
Sistema para generar, validar, listar y revocar API Keys usando **PHP**, **SQLite** y **Docker**.  
Incluye una interfaz sencilla en HTML/CSS/JS para administrar las claves.

##Características

- Generación de API Keys únicas
- Validación de claves
- Revocación de claves
- Listado de claves activas y revocadas
- Arquitectura modular (Controladores, Servicios, Repositorios)
- Base de datos SQLite
- Servidor con Docker (Nginx + PHP-FPM)
- Interfaz web para administración

---

## Requisitos

Asegúrate de tener instalado:

- **Docker**  
- **Docker Compose**
- (Opcional) **Git**

---
##Para correr el proyecto primero ejecuta:
docker compose up -d
#Para probar la interfaz web
http://localhost:8080/panel/index.html
#Para probar por curl:
http://localhost:8080/generate
asi con todos los metodos, revoke

## 🛠 Instalación

Clona el repositorio:

```bash
git clone https://github.com/kikevare/api-key-manager.git
cd api-key-manager
