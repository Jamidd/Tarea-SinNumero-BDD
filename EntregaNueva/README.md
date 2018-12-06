# Entrega 5 Bases de Datos

## Grupo 23



Para iniciar la API, se debe entrar a la página [http://rapanui28.ing.puc.cl](http://rapanui28.ing.puc.cl) (Es sólo un 'Hello World!')

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
http://rapanui28.ing.puc.cl/search?id=1&1=hola|como|estas&2=uwu|owo&3=fernando|pieressa
```

La ruta anterior busca los mensajes del usuario con id=1, que tenga las palabras "hola", "como", "estas" y que tenga "owo" o "uwu" en la frase, mientras que no puede tener las palabras "fernando" o "pieressa".

(POST) Para agregar un mensaje, se debe ingresar a la ruta: /add_message y anotar los parámetros

- 1=<id\> id del emisor
- 2=<id\> id del receptor
- m=<texto\> mensaje enviado

Estos parámetros deben tener antepuestos el símbolo "?" y para separarlos se debe hacer con el símbolo "&". Por ejemplo:

```
http://rapanui28.ing.puc.cl/add_message?1=23&2=12&m=hola como estas
```

La ruta anterior agrega un mensaje del usuario con id=1, al usuario con id=2 y el mensaje seria m=hola como estas.
El id, latitud, longitud y fecha se agregan automaticamente

(POST) Para eliminar un mensaje, se debe ingresar a la ruta: /delete_message y anotar los parámetros

- mid=<id\> id del mensaje a eliminar

Estos parámetros deben tener antepuestos el símbolo "?" y para separarlos se debe hacer con el símbolo "&". Por ejemplo:

```
http://rapanui28.ing.puc.cl/delete_message?mid=3
```

Para ingresar a la aplicacion se debe entrar a la apagina [http://bases.ing.puc.cl/~grupo23/E5/](http://bases.ing.puc.cl/~grupo23/E5/).

Al hacer login, si se selecciona mensajeria, aparecen las funcionalidades que consumen la API requeridas para esta entrega.

La aplicacion debe probarse en un buscador que no sea Safari, ya que la funcionalidad de geolocalizacion no es compatible con este.



