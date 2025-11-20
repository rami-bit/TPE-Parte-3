
# TPE TERCERA ENTREGA

Integrantes:
Tobias Davila- tobiasdavnic.13@gmail.com
Ramiro Del Valle- ramidv12@gmail.com

📁 para que funcione bien la api se necesita la base de datos se encuentra en el directorio /sql/noticiero.sql. Puede importarse manualmente desde phpMyAdmin o usarse para auto-deploy.

# Usuario Administrador
```http
  nombre: webadmin
  contraseña: admin
```

# Documentación de la API REST — Noticias
### 🔐 Autenticación
Para acceder a los endpoints restringidos, primero debés iniciar sesión y obtener un token JWT. Este token debe incluirse en el encabezado Authorization como Bearer <token> en cada solicitud protegida.

```http
  GET ../api/auth/login
```


| Parametro | tipo     | Descripción                       |
| :-------- | :------- | :-------------------------------- |
| `nombre`      | `varchar(70)` |*Required*. Nombre de usuario |
|`password` |varchar(300) |Required. Contraseña de usuario |

Response: devuelve el token jwt.

### 📄Endpoints publicos
#### Obtener todas las noticias
```http
  GET ../api/noticias
```
| Parametro | tipo     | Descripción                       |
| :-------- | :------- | :-------------------------------- |
| `ninguno`      | `-` |Retorna un arreglo de objetos noticia |


#### Obtener noticias filtradas por juego
```http
  GET ../api/noticias?game=id-juego
```

| QueryParam | tipo     | Descripción                       |
| :-------- | :------- | :-------------------------------- |
| `game`      | `int` |Required. Id del juego a filtrar|


> 📌Nota: este filtro se aplica al campo `seccion_id` de la noticia y este filtro se puede combinar con paginado y orden por campo (ascendente o descendente).

#### Obtener noticias ordenadas por algun campo

```http
Ejemplos de uso:
GET ../api/noticias?orderby=titulo&order=asc
GET ../api/noticias?orderby=contenido&order=desc
```


| QueryParam | tipo     | Descripción                       |
| :-------- | :------- | :-------------------------------- |
| `orderby`      | `string` |Required. campo de noticia al cual ordenar|
| `order`|`string` |Required. Manera de ordenar el listado |

> 📌Nota: el controlador chequea que tanto el campo elegido para ordenar exista, que la forma de ordenarlo sea o ascendente o descendente (se puede pasar en minusculas o mayusculas) y por ultimo, que se pasen de a pares (orderby y order) sino devuelve un error(400 Bad Request). El ordenamiento se puede combinar con paginado y con el filtro por juego.


#### Obtener noticias con paginado
```http
  GET ../api/noticias?page=1&limit=10 // Valores de page y limit son un ejemplo
```
| QueryParam | tipo     | Descripción                       |
| :-------- | :------- | :-------------------------------- |
| `page`      | `int` |Required.Pagina que se quiere ver|
| `limit`|`int` |Required. maximo de noticias por páginas|


>📌Nota: El offset se calcula automáticamente a partir de page y limit en el backend. No debe enviarse por URL. El paginado solo se aplica si se pasa por query el par `limit` y `page`.Tambien se puede combinar con el filtro y ordenamiento por campos. 

----
#### Obtener una noticia por su ID
```http
  GET ../api/noticias/${id}
```


| Parametro | tipo     | Descripción                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` |*Required*. ID de la noticia a obtener |

### 🔒Endpoints protegidos
```http
Requieren autenticación mediante token JWT en el encabezado Authorization: Bearer <token>.
```

#### Crear Nueva Noticia

```http
  POST ../api/noticias
```


| Parametro | tipo     | Descripción                       |
| :-------- | :------- | :-------------------------------- |
| `titulo`      | `varchar(255)` | Required. Título de la noticia |
|     `img`      |`varchar(255)` |Required.URL de la imagen |
| `resumen`| `varchar(200)`|Required. Resumen breve de la noticia|
|`contenido` |`longtext` |Required.Contenido completo de la noticia | 

```http
Ejemplo de body JSON
 
{
  "titulo": "Nuevo evento tecnológico",
  "img": "urlimagen",
  "resumen": "Resumen corto del evento.",
  "contenido": "Contenido completo de la noticia..."
}
```
#### Editar Noticia

```http
PUT ../api/noticias/${id}
```

| Parametro | tipo     | Descripción                       |
| :-------- | :------- | :-------------------------------- |
| `titulo`      | `varchar(255)` | Required. Título de la noticia |
|     `img`      |`varchar(255)` |Required.URL de la imagen |
| `resumen`| `varchar(200)`|Required. Resumen breve de la noticia|
|`contenido` |`longtext` |Required.Contenido completo de la noticia | 
 
> 📌 Nota: El id de la noticia debe pasarse en la URL como parámetro de ruta.

```http
Ejemplo de body JSON

{
  "titulo": "Nuevo evento tecnológico",
  "img": "urlimagen",
  "resumen": "Resumen corto del evento.",
  "contenido": "Contenido completo de la noticia..."
}

```


