# Entrega 4 Bases de Datos

## Grupo 23

Para importar las bases de datos, se debe correr en la consola de mongo:

```bash
mongoimport --db test --collection usuarios --drop --file <PATH archivo usuarios.json> --jsonArray
```

```bash
mongoimport --db test --collection messages --drop --file <PATH archivo messages.json> --jsonArray
```

Por favor notar que <PATH archivo *.json> son paths que tienen que ser agregados por el ayudante.

Con esto se suben las bases de datos a MongoDB

Para correr la API se debe correr el comando:

```bash
python __init__.py
```

Esto iniciará la API en ***localhost*** con puerto definido como variable en el archivo .py, por defecto es 5000.

Por lo tanto, debe entrar a la página [http://localhost:5000/](http://localhost:5000/) (Es sólo un 'Hello World!')

(GET) Para ver la información de un usuario, se debe ingresar a la ruta: /user/<id>

 - El formato del output es un diccionario {'messages': lista_de mensajes, 'user': usuario} donde *lista_de_mensajes* es una lista de toda la información de los mensajes y *usuario* es la información del usuario.

(GET) Para ver la información de un mensaje, se ingresa a la ruta: /message/<id>

 - El ID de un mensaje fue agregado manualmente, permitido por [esta issue](https://github.com/IIC2413/Syllabus-2018-2/issues/147). El output es la información del mensaje.





