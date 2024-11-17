# Trabajo Práctico Especial Parte 3

Trabajo con API REST acerca de la serie animada Bajoterra.

# Integrantes
- Jean Thomassen.
- Lautaro Zijlstra.

## Descripción

Hicimos un sistema que almacena y permite visualizar los capítulos de esta serie animada. Este proyecto está realizado con una API REST que permite la consulta, modificación e inserción de capítulos.

## Endpoints
| Request                     | método   | endpoint                   | verbo |
|-----------------------------|----------|----------------------------|-------|
| Listar capítulos            | `getall` | `capitulos`                | `GET` |
| Obtener un capítulo         | `get`    | `capitulos/:id`            | `GET` |
| Agregar un capítulo         | `add`    | `capitulos`                | `POST`|
| Editar un capítulo          | `update` | `capitulos/:id`            | `PUT` |

---

- **GET** `tpe-web2-api/api/capitulos`

    Devuelve todos los capítulos, permitiendo aplicar un filtrado por temporada y ordenado opcional.

- **Query params**
    - **Filtrado**
        - `temporada` Filtra la lista de capítulos y muestra solo la temporada ingresada.
            ``` 
            tpe-web2-api/api/capitulos?temporada=1 
            ```
    - **Ordenado**
        - `orderBy` Ordena la lista. Los campos pueden ser:
            - `temporada` Ordena la lista por su temporada.
                ```
                tpe-web2-api/api/capitulos?orderBy=temporada
                ```
            - `titulo` Ordena la lista por su título.
                ```
                tpe-web2-api/api/capitulos?orderBy=titulo
                ```
        - `direc` Dirección hacia donde se ordena la lista, puede ser:
            - `ASC` ⬆️ Ordenado de forma ascendente (si no se ingresa nada, está por defecto).
            - `DESC` ⬇️ Ordenado de forma descendente.
        - ***Ejemplo***
            ```
            tpe-web2-api/api/capitulos?orderBy=titulo&direc=DESC
            ```

---

- **GET** `tpe-web2-api/capitulos/:id`

    Devuelve el capítulo correspondiente al __id__ ingresado.

---

- **POST** `tpe-web2-api/capitulos`

    Inserta un capítulo con la información en el cuerpo de la solicitud (__JSON__).

    - **Campos ___obligatorios___** ⚠️
        - `titulo`: Título del capítulo.
        - `descripcion`: Descripción del capítulo.
        - `video`: URL del capítulo de YouTube.
        - `temporada`: Temporada ya existente en la base de datos. 
    **Ejemplo**
    ```json
    {
        "titulo": "Capítulo 1",
        "descripcion": "Descripción del capítulo 1",
        "video": "url del video",
        "temporada": "1"
    }
    ```
---

- **PUT** `tpe-web2-api/capitulos/:id`

    Modifica el capítulo correspondiente al __id__ ingresado, con la información en el cuerpo de la solicitud (__JSON__).

    - **Campos modificables**
        - `titulo`: Título del capítulo.
        - `descripcion`: Descripción del capítulo.
        - `video`: URL del capítulo de YouTube.
        - `temporada`: Temporada ya existente en la base de datos. 
    **Ejemplo**
    ```json
    {
        "titulo": "Capítulo 2",
        "descripcion": "Descripción del capítulo 2",
        "video": "url del video de otro capítulo",
        "temporada": "5"
    }
    ```