# Integrantes
Daniela Waldeck
Pedro Inciarte

# Instrucciones

## Instalar dependencias
$ npm install -D tailwindcss

Si no tienes npm instalado primero debes hacer $ sudo apt install npm

## Para desplegar el proyecto:
1. Sitúa la terminal dentro del directorio donde tienes el proyecto
2. Construye la imagen web: $ docker build -t="web" .
3. Despliega los servicios mediante $ docker-compose up
4. Visita la web en http://localhost:81. 

Para añadir los datos necesarios, visita http://localhost:8890/
usuario: admin
contraseña: test
Hacer click en "database" y luego en "import". Seleccionar archivo database.sql 

Para frenar el container
```bash
$ docker-compose stop
```
## Usuarios precargados
Hemos dejado dos usuarios precargados
1. Usuario: daniwal  contraseña: 12345678
2. Usuario: peli     contraseña: 12345678