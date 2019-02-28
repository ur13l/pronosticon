---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#Auth
<!-- START_a925a8d22b3615f12fca79456d286859 -->
## Login
Método post que procesa el logueo.

> Example request:

```bash
curl -X POST "http://localhost/api/auth/login" 
```

```javascript
const url = new URL("http://localhost/api/auth/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/auth/login`


<!-- END_a925a8d22b3615f12fca79456d286859 -->

#Quinielas
<!-- START_2affed122be4f7e7be8255733f0f44f4 -->
## Index
Devuelve el index, ya sea vista de jugador o administrador.

> Example request:

```bash
curl -X GET -G "http://localhost/api/quinielas" 
```

```javascript
const url = new URL("http://localhost/api/quinielas");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/quinielas`


<!-- END_2affed122be4f7e7be8255733f0f44f4 -->

<!-- START_3e6bbc6a40f1842ad65e3688c17a6aa0 -->
## Detalle Quiniela
Devuelve el detalle de una quiniela dando su ID como entrada.

> Example request:

```bash
curl -X GET -G "http://localhost/api/quinielas/{id_quiniela}" 
```

```javascript
const url = new URL("http://localhost/api/quinielas/{id_quiniela}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/quinielas/{id_quiniela}`


<!-- END_3e6bbc6a40f1842ad65e3688c17a6aa0 -->


