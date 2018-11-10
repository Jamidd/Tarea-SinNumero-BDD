# Entrega 4 Bases de Datos

## Grupo 23

Para importar las bases de datos, se debe correr en la consola:

```bash
mongoimport --db test --collection usuarios --drop --file <PATH archivo usuarios.json> --jsonArray
```

```bash
mongoimport --db test --collection messages --drop --file <PATH archivo messages.json> --jsonArray
```

Por favor notar que <PATH archivo *.json> son paths que tienen que ser agregados por el ayudante.

Con esto se suben las bases de datos a MongoDB

Para que nuestra búsqueda de texto funcione correctamente, ahora debemos entrar a la consola de mongo y correr el comando:

```python
db.messages.createIndex( { message: "text" } );
```
Para instalar las dependecias en linux, utilizar 

```bash
make
```
En caso de no estar en linux, se requieren las librerias time y geocoder. 

Para correr la API se debe correr el comando:

```bash
python3 __init__.py
```
Esto iniciará la API en ***localhost*** con puerto definido como variable en el archivo .py, por defecto es 5000.

Por lo tanto, debe entrar a la página [http://localhost:5000/](http://localhost:5000/) (Es sólo un 'Hello World!')

(GET) Para ver la información de un usuario, se debe ingresar a la ruta: /user/<id> 

 - El formato del output es un diccionario {'messages': lista_de mensajes, 'user': usuario} donde *lista_de_mensajes* es una lista de toda la información de los mensajes y *usuario* es la información del usuario.

(GET) Para ver la información de un mensaje, se ingresa a la ruta: /message/<id>

 - El ID de un mensaje fue agregado manualmente, permitido por [esta issue](https://github.com/IIC2413/Syllabus-2018-2/issues/147). El output es la información del mensaje.

(GET) Para ver los mensajes entre dos usuarios, se ingresa a la ruta /users/<id1>&<id2>

- Es importante que la separación entre los ID sea "&". El output es una lista de los mensajes que fueron intercambiados.

(GET) Para buscar texto, se debe ingresar a la ruta: /search y anotar los parámetros

- user=<id\> para buscar un id de usuario determinado
- 1=<texto\> para agregar frases que si o si deben estar en el mensaje, las frases deben estar separadas por el caracter "|"
- 2=<texto\> para agregar palabras que deseablemente deben estar, separadas por "|"
- 3=<texto\> para agregar palabras que estan prohibidas, separadas por "|"

Estos parámetros deben tener antepuestos el símbolo "?" y para separarlos se debe hacer con el símbolo "&". Por ejemplo:

```
localhost:5000/search?id=1&1=hola|como|estas&2=uwu|owo&3=fernando|pieressa
```

La ruta anterior busca los mensajes del usuario con id=1, que tenga las palabras "hola", "como", "estas" y que tenga "owo" o "uwu" en la frase, mientras que no puede tener las palabras "fernando" o "pieressa".

(POST) Para agregar un mensaje, se debe ingresar a la ruta: /add_message y anotar los parámetros

- 1=<id\> id del emisor
- 2=<id\> id del receptor
- m=<texto\> mensaje enviado

Estos parámetros deben tener antepuestos el símbolo "?" y para separarlos se debe hacer con el símbolo "&". Por ejemplo:

```
localhost:5000/add_message?1=23&2=12&m=hola como estas
```

La ruta anterior agrega un mensaje del usuario con id=1, al usuario con id=2 y el mensaje seria m=hola como estas.
El id, latitud, longitud y fecha se agregan automaticamente

(POST) Para eliminar un mensaje, se debe ingresar a la ruta: /delete_message y anotar los parámetros

- mid=<id\> id del mensaje a eliminar

Estos parámetros deben tener antepuestos el símbolo "?" y para separarlos se debe hacer con el símbolo "&". Por ejemplo:

```
localhost:5000/delete_message?mid=3
```




